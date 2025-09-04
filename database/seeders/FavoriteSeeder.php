<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $image = UserImage::first();

        Favorite::create([
            'user_id' => $user->id,
            'imageable_id' => $image->id,
            'imageable_type' => UserImage::class,
        ]);
    }
}
