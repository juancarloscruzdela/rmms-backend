<?php

namespace Database\Seeders;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('videos')->delete();
        $data = [
            [
                'title' => 'Video 1',
                'description' => 'Video 1 Description',
                'category'=> 'mathematics',
                'file' => null,
                'views' => '32',
                // 'user_id' => 1,
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Video 2',
                'description' => 'Video 2 Description',
                'category'=> 'mathematics',
                'file' => null,
                'views' => '32',
                // 'user_id' => 1,
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Video 3',
                'description' => 'Video 3 Description',
                'category'=> 'mathematics',
                'file' => null,
                'views' => '32',
                // 'user_id' => 1,
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        Video::insert($data);

        // Testing Dummy Videos
        Video::factory(100)->create();
    }
}
