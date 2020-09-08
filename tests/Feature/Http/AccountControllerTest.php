<?php

namespace Wingsline\Blog\Tests\Feature\Http;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wingsline\Blog\Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \Wingsline\Blog\Http\Controllers\AccountController::edit
     */
    public function testEdit()
    {
        $user = $this->loginUser();
        $response = $this->be($user)->get('admin/account');

        $response->assertStatus(200);
        $response->assertViewIs('blog::account.edit');
        $response->assertViewHas('user', $user);
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\AccountController::update
     */
    public function testUpdate()
    {
        $user = $this->loginUser();

        // update the user
        $response = $this->be($user)
            ->put(
                'admin/account',
                [
                    'name' => 'Bar',
                    'email' => 'bar@example.com',
                    'password' => 'secret123',
                    'password_confirmation' => 'secret123',
                ]
            );
        $user->fresh();

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        self::assertSame('Bar', $user->getAttribute('name'));
        self::assertSame('bar@example.com', $user->getAttribute('email'));
        self::assertTrue(
            app('hash')->check('secret123', $user->getAttribute('password'))
        );
        $response->assertSessionHas(
            'laravel_flash_message',
            ['message' => 'Account updated.', 'class' => '', 'level' => 'success']
        );
        $response->assertRedirect('admin/account');
    }

    /**
     * @covers \Wingsline\Blog\Http\Controllers\AccountController::update
     */
    public function testUpdateWithErrors()
    {
        $user = $this->loginUser();
        $response = $this->be($user)
            ->put('admin/account');
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
        ]);
    }
}
