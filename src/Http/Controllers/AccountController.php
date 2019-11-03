<?php

namespace Wingsline\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Wingsline\Blog\Http\Requests\AccountEditRequest;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('blog::account.edit', compact('user'));
    }

    public function update(AccountEditRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (null !== $validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        if (\count($user->getChanges())) {
            flash()->success('Account updated.');
        }

        return redirect()->route('admin.account.edit');
    }
}
