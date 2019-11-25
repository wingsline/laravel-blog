<?php

namespace Wingsline\Blog\Database\Seeds;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        /** @var User $user */
        $user = config('auth.providers.users.model');
        if (! DB::table((new User)->getTable())->where('email', 'admin@example.com')->exists()) {
            $user::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
            ]);
        }
    }
}
