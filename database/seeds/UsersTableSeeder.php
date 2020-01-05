<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961301_WioWOheY9j.png',
            'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961360_13SsPykBcA.png',
            'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961394_njX2PIwj8P.png',
            'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961421_oJGQ0KQunT.png',
            'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961439_bywK8Z2HZQ.png',
        ];

        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) use ($faker, $avatars){
            $user->avatar = $faker->randomElement($avatars);
        });

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($user_array);

        $user         = User::find(1);
        $user->name   = 'Summer';
        $user->email  = 'summer@example.com';
        $user->avatar = 'http://120.79.167.67/uploads/images/avatar/201911/17/1_1573961301_WioWOheY9j.png';
        $user->save();
    }
}
