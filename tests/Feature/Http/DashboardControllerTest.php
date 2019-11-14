<?php

namespace Wingsline\Blog\Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Posts\Post;
use Wingsline\Blog\Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Http\Controllers\DashboardController::__invoke()
     */
    public function testDashboardPage()
    {
        factory(Post::class)->create(['title' => 'foo-title']);
        factory(Post::class)->create(['title' => 'bar-title']);

        $user = $this->loginUser();
        $response = $this->be($user)->get('admin');

        $response->assertStatus(200);
        $response->assertSee('Latest Posts');
        $response->assertSee('Sign Out');
        $response->assertSee('New Post');
        $response->assertSee('foo-title');
        $response->assertSee('bar-title');
    }
}
