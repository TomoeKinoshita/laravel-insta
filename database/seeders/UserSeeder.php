<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; //

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     */


    // protected function create(array $data)  // これはユーザー新規register後の自動送信メールについてのコードをRegisterControllerに書いたときに用いたfunction。ここでは作成不要。
    // {
    //     $user = User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'avatar' => $data['avatar'],
    //         'password' => Hash::make($data['password']),
    //         'introduction' => $data['introduction'],
    //         'role_id' => $data['role_id'],
    //         'created_at' => $data['created_at'],
    //         'updated_at' => $data['updated_at']
    //     ]);

    //     // $details = [
    //     //     'name' => $user->name,
    //     //     'email' => $user->email,
    //     //     'avatar' => $user->avatar,
    //     //     'password' => $user->password,
    //     //     'introduction' => $user->introduction,
    //     //     'role_id' => $user->role_id,
    //     //     'created_at' => $user->created_at,
    //     //     'updated_at' => $user->updated_at
    //     // ];

    //     return $user;
    // }

    public function run(): void
    {
        //
        $users = [
            [
                'name' => 'Alice',
                'email' => 'alice@gmail.com',
                'avatar' => NULL,
                'password' => Hash::make('alicealice'),
                'introduction' => NULL,
                'role_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Teddy',
                'email' => 'teddy@gmail.com',
                'avatar' => NULL,
                'password' => Hash::make('teddyteddy'),
                'introduction' => NULL,
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Gina',
                'email' => 'gina@gmail.com',
                'avatar' => NULL,
                'password' => Hash::make('ginagina'),
                'introduction' => NULL,
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->user->insert($users);
    }
}
