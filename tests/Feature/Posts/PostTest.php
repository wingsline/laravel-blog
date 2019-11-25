<?php

namespace Wingsline\Blog\Tests\Feature\Posts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Posts\Post::getMarkdownAttribute()
     */
    public function testGetMarkdownAttribute()
    {
        $post = factory(Post::class)->create(['text' => 'foo-text']);
        self::assertSame('foo-text', $post->markdown);
    }

    /**
     * @covers \Wingsline\Blog\Posts\Post::getSlugOptions()
     */
    public function testGetSlugOptions()
    {
        $options = (new Post())->getSlugOptions();
        self::assertSame(['title'], $options->generateSlugFrom);
        self::assertSame('slug', $options->slugField);
    }

    /**
     * @covers \Wingsline\Blog\Posts\Post::getTextAttribute()
     */
    public function testGetTextAttribute()
    {
        // using the package's parser
        $post = new Post();
        $post->text = '# foo';
        self::assertSame("<h1>foo</h1>\n", $post->text);
    }

    /**
     * @covers \Wingsline\Blog\Posts\Post::scopePublic()
     */
    public function testScopePublic()
    {
        factory(Post::class)
            ->create([
                'title' => 'foo-title',
                'publish_date' => now(),
            ]);
        factory(Post::class)->create([
            'title' => 'bar-title',
            'publish_date' => now()->subDay(),
        ]);
        factory(Post::class)->create([
            'title' => 'baz-title',
            'publish_date' => now()->addDay(),
        ]);

        $posts = Post::public()->get();
        self::assertCount(2, $posts);
        self::assertSame(
            ['foo-title', 'bar-title'],
            $posts->pluck('title')->toArray()
        );
    }

    /**
     * @covers \Wingsline\Blog\Posts\Post::scopePublished()
     */
    public function testScopePublished()
    {
        factory(Post::class)->create([
            'title' => 'foo-title',
            'published' => 0,
        ]);
        factory(Post::class)->create([
            'title' => 'bar-title',
            'published' => 1,
        ]);

        $posts = Post::published()->get();
        self::assertCount(1, $posts);
        self::assertSame($posts->first()->title, 'bar-title');
    }

    /**
     * @covers \Wingsline\Blog\Posts\Post::updateAttributes()
     */
    public function testUpdateAttributes()
    {
        $user = $this->loginUser();

        /** @var Post $post */
        $post = factory(Post::class)->create(['title' => 'foo-title']);
        $now = now();

        $attributes = [
            'title' => 'bar-title',
            'text' => 'foo-text',
            'publish_date' => $now,
            'published' => '1',
            'original_content' => '1',
            'external_url' => 'http://foo.example.com',
            'tags_text' => 'foo, bar',
        ];

        $post->updateAttributes($attributes);
        $post = $post->fresh();

        // assetions
        self::assertSame($post->getOriginal('title'), 'bar-title');
        self::assertSame($post->getOriginal('text'), 'foo-text');
        self::assertSame($post->getOriginal('publish_date'),
            $now->format('Y-m-d H:i:s'));
        self::assertSame($post->getOriginal('published'), 1);
        self::assertSame($post->getOriginal('original_content'), 1);
        self::assertSame($post->getOriginal('external_url'),
            'http://foo.example.com');
        self::assertSame($post->getOriginal('author'),
            $user->getAttribute('name'));
        self::assertSame($post->tags->pluck('name')->toArray(), ['foo', 'bar']);
    }
}
