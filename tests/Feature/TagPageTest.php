<?php

namespace Wingsline\Blog\Tests\Feature;

use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagPageTest extends TestCase
{
    use RefreshDatabase;

    public function testIt_shows_the_tagged_posts()
    {
        $post = factory(Post::class)->create(['title' => 'foo-title', 'published' => 1]);
        $post->syncTags(['foo', 'bar']);
        factory(Post::class)->create(['title' => 'bar-title', 'published' => 1]);

        $response = $this->get('/tag/foo');

        $response->assertStatus(200);
        $response->assertSee('foo-title');
        $response->assertDontSee('bar-title');
    }
}
