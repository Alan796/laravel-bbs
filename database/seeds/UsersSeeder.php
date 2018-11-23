<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create();

        $user_1 = User::find(1);
        $user_1->name = 'Alan';
        $user_1->email = 'chenwu796@163.com';
        $user_1->save();
    }
}
