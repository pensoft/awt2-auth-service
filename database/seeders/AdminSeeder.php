<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Lauthz\Facades\Enforcer;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = collect([
            [
                'name' => 'Super Admin',
                'email'    => 'admin@pensoft.net',
                'role' => 'SuperAdmin'
            ],
            [
                'name' => 'Author',
                'email'    => 'author@pensoft.net',
                'role' => 'author'
            ],
            [
                'name' => 'Editor',
                'email'    => 'editor@pensoft.net',
                'role' => 'editor'
            ],
            [
                'name' => 'Reader',
                'email'    => 'reader@pensoft.net',
                'role' => 'reader'
            ]
        ]);
        $users->each(fn ($user) => $this->addUser($user));

    }

    private function addUser($user){
        if(!User::where('email', $user['email'])->first()) {
            $u = User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => Hash::make($user['email'])
            ]);

            // Assign role `author` to the new registered users
            Enforcer::addRoleForUser($u->id, $user['role']);
        }
    }
}
