<?php

namespace Wingsline\Blog\Tests\Feature;

use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomePageTest extends TestCase
{
    use RefreshDatabase;

    public function testIt_shows_list_of_posts()
    {
        // create some published posts
        factory(Post::class)->create(['title' => 'foo-title', 'published' => 1]);
        factory(Post::class)->create(['title' => 'bar-title', 'published' => 1]);
        factory(Post::class)->create(['title' => 'baz-title', 'published' => 0]);
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('foo-title');
        $response->assertSee('bar-title');
        $response->assertDontSee('baz-title');
    }
}
