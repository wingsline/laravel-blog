<?php

namespace Wingsline\Blog\Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Http\Controllers\LoginController;
use Wingsline\Blog\Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Http\Controllers\LoginController::showLoginForm()
     */
    public function testShowLoginForm()
    {
        // go to admin, check if redirects to login
        $response = $this->get('admin');
        $response->assertStatus(302);
        $response->assertRedirect('admin/login');

        // go to login, check view
        $response = $this->get('admin/login');
        $response->assertStatus(200);
        $response->assertViewIs('blog::auth.login');
        $response->assertSee('Sign In');
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\LoginController::username()
     */
    public function testUsername()
    {
        $controller = new LoginController();
        self::assertSame('email', $controller->username());
    }
}
