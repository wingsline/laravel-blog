<?php

namespace Wingsline\Blog\Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::create
     */
    public function testCreate()
    {
        $user = $this->loginUser();
        $response = $this->be($user)->get('admin/posts/create');

        $response->assertStatus(200);
        $response->assertViewIs('blog::posts.create');
        $response->assertViewHas('post');
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::destroy()
     */
    public function testDestroy()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $user = $this->loginUser();
        $response = $this->be($user)->delete('admin/posts/'.$post->id);

        $response->assertStatus(302);

        $response->assertSessionHas(
            'laravel_flash_message',
            ['message' => 'Post deleted.', 'class' => '', 'level' => 'success']
        );

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::edit
     */
    public function testEdit()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title']);

        $user = $this->loginUser();
        $response = $this->be($user)->get('admin/posts/'.$post->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('blog::posts.edit');
        $response->assertViewHas('post', $post);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::index()
     */
    public function testIndex()
    {
        factory(Post::class)->create(['title' => 'foo-title']);
        factory(Post::class)->create(['title' => 'bar-title']);
        factory(Post::class)->create(['title' => 'baz-title']);

        $user = $this->loginUser();
        $response = $this->be($user)->get('admin/posts');

        $response->assertStatus(200);
        $response->assertSee('foo-title');
        $response->assertSee('bar-title');
        $response->assertSee('baz-title');
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::preview()
     */
    public function testPreview()
    {
        $user = $this->loginUser();
        $response = $this->be($user)->post('admin/posts/preview',
            ['payload' => '# foo']);

        $response->assertStatus(200);
        $response->assertJson(['data' => ['html' => "<h1>foo</h1>\n"]]);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::store()
     */
    public function testStore()
    {
        $user = $this->loginUser();
        $response = $this->be($user)
            ->post(
                'admin/posts',
                [
                    'title' => 'new-post',
                    'text' => 'new text',
                    'tags_text' => '',
                    'publish_date' => now()->format('Y-m-d H:i:s'),
                    'external_url' => '',
                    'published' => '1',
                    'original_content' => '1',
                ]
            );

        $response->assertStatus(302);

        $response->assertSessionHas(
            'laravel_flash_message',
            ['message' => 'Post saved.', 'class' => '', 'level' => 'success']
        );
        $post = Post::where('title', 'new-post')->first();
        $response->assertRedirect('admin/posts/'.$post->id.'/edit');
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::store()
     */
    public function testStoreWithErrors()
    {
        $user = $this->loginUser();
        $response = $this->be($user)->post('admin/posts');

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'text' => 'The text field is required.',
        ]);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::update()
     */
    public function testUpdate()
    {
        /** @var Post $post */
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $user = $this->loginUser();
        $response = $this->be($user)
            ->put(
                'admin/posts/'.$post->id,
                [
                    'title' => 'updated-post',
                    'text' => 'updated text',
                    'tags_text' => 'foo, bar',
                    'publish_date' => now()->format('Y-m-d H:i:s'),
                    'external_url' => '',
                    'published' => '1',
                    'original_content' => '1',
                ]
            );

        $response->assertStatus(302);
        $response->assertSessionHas(
            'laravel_flash_message',
            ['message' => 'Post updated.', 'class' => '', 'level' => 'success']
        );
        $response->assertRedirect('admin/posts/'.$post->id.'/edit');

        $post = $post->fresh();
        self::assertSame('updated-post', $post->getAttribute('title'));
        self::assertSame(
            ['bar', 'foo'],
            $post->getRelation('tags')->sortBy->name->pluck('name')->toArray()
        );
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::update()
     */
    public function testUpdateWithErrors()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $user = $this->loginUser();
        $response = $this->be($user)->put('admin/posts/'.$post->id);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'text' => 'The text field is required.',
        ]);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::upload()
     */
    public function testUpload()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $image = UploadedFile::fake()->image('image.jpg');
        $user = $this->loginUser();
        $response = $this->be($user)->post(
            'admin/posts/upload/'.$post->id,
            ['image' => $image]
        );

        $response->assertStatus(200);
        $response->assertJson(
            ['data' => ['filePath' => 'storage/1/image.jpg']]
        );
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\PostsController::upload()
     */
    public function testUploadErrors()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $user = $this->loginUser();
        $response = $this->be($user)
            ->post(
                'admin/posts/upload/'.$post->id,
                ['image' => 'invalid']
            );

        $response->assertStatus(422);
        $response->assertJson(
            ['error' => 'The image must be a file of type: jpeg, png.']
        );
    }
}
