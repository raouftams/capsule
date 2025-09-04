<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Seeder;

class UserImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        UserImage::create([
            'user_id' => $user->id,
            'title' => 'Sunset Over Lake Michigan',
            'description' => 'A calming view inspired by Chicago skies.',
            'image_path' => 'user-images/claude-monet.jpg', 
        ]);

        UserImage::create([
            'user_id' => $user->id,
            'title' => 'Abstract Colors',
            'description' => 'A vibrant abstract painting with mixed media.',
            'image_path' => 'user-images/bust-of-a-man.jpg',
        ]);
    }
}
