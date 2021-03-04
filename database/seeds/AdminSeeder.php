<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::updateOrCreate(["email" => env('SUPER_ADMIN_EMAIL')],[
            "email" => env('SUPER_ADMIN_EMAIL'),
            "password" => Hash::make(env('SUPER_ADMIN_PASSWORD')),
            "name" => "Alaje",
            "phone_number" => "08177171797",
            "user_type" => "super_admin",
            "last_activity_entry" => Carbon::now(),
            "email_verified" => 1,
            "active" => 1
        ]);
    }
}
