<?php

use Illuminate\Database\Seeder;
use App\Models\User;

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
            'https://cdn.learnku.com/uploads/avatars/25461_1566040158.JPG!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/1_1530614766.png!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/5320_1470791886.jpeg!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/32249_1545124984.jpg!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/24372_1523868790.jpg!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/76_1451276555.png!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/29791_1552314544.jpeg!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/27516_1556075217.png!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/3995_1516760409.jpg!/both/100x100',
            'https://cdn.learnku.com/uploads/avatars/851_1533190937.png!/both/100x100',
            'https://cdn.learnku.com//uploads/communities/sNljssWWQoW6J88O9G37.png',
            'https://cdn.learnku.com//uploads/communities/iAphQ2R2SYGDdQ6cd7aD.png',
            'https://cdn.learnku.com//uploads/communities/WtC3cPLHzMbKRSZnagU9.png',
            'https://cdn.learnku.com/uploads/avatars/5350_1481857380.jpg!/both/100x100',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(100)
                        ->make()
                        ->each(function ($user, $index)
                            use ($faker, $avatars)
        {
            // 从头像数组中随机取出一个并赋值
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见，并将数据库集合转为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'foo';
        $user->email = 'bar@example.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
