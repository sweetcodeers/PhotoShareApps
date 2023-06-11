<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photoPath = public_path('images/profiles/photo1.jpg');

        $image = Image::make($photoPath)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

        $photoName = 'photo_' . time() . '.jpg';

        $image->save(public_path('photos/' . $photoName));

        DB::table('photos')->insert([
            [
                'user_id'    => 1,
                'caption'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vitae odio leo. Nam aliquet lacus sapien. Aenean auctor convallis libero non efficitur.',
                'photo'      => 'photos/' . $photoName,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
