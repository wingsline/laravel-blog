<?php


namespace Wingsline\Blog\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
