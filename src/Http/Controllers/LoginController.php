<?php

namespace Wingsline\Blog\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LoginController extends BaseController
{
    use AuthenticatesUsers;
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Max login attempts.
     *
     * @var int
     */
    protected $maxAttempts;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->maxAttempts = config('blog.maxAttempts');
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('blog::auth.login');
    }

    /**
     * Username field.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Redirect after login.
     */
    protected function redirectTo()
    {
        return config('blog.prefix');
    }
}
