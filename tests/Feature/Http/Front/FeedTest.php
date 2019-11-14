<?php

namespace Wingsline\Blog\Tests\Feature\Http\Front;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    public function testContains_the_posts_in_the_feed()
    {
        factory(Post::class)->create([
            'title' => 'foo-title',
            'published' => 1
        ]);
        factory(Post::class)->create([
            'title' => 'bar-title',
            'published' => 1
        ]);
        factory(Post::class)->create([
            'title' => 'baz-title',
            'published' => 0
        ]);

        $response = $this->get('/feed/blog');

        $response->assertStatus(200);
        $response->assertSee('foo-title');
        $response->assertSee('bar-title');
        $response->assertDontSee('baz-title');
    }
}
