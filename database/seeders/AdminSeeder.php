<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Librarian;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Librarian';
        $user->role = 'Librarian';
        $user->email = 'bookback@gmail.com';
        $user->password = bcrypt('password');
        $user->save();

        $staff = new Librarian;
        $staff->name = 'Librarian';
        $staff->email = 'bookback@gmail.com';
        $staff->sex = 'Need to Update';
        $staff->phone = 'Need to Update';
        $staff->address = 'Need to Update';
        $staff->birthdate = now();
        $staff->age = 'Need to Update';
        $staff->user_id = $user->id;
        $staff->save();
    }
}
