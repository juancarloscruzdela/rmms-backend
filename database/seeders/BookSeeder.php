<?php

namespace Database\Seeders;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->delete();
        $data = [
            [
                'title' => 'Book 1',
                'description' => 'Book 1 Description',
                'category'=> 'mathematics',
                'file' => null,
                'downloads' => '23',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Book 2',
                'description' => 'Book 2 Description',
                'category'=> 'mathematics',
                'file' => null,
                'downloads' => '23',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Book 3',
                'description' => 'Book 3 Description',
                'category'=> 'mathematics',
                'file' => null,
                'downloads' => '23',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        Book::insert($data);

        // Testing Dummy Books
        Book::factory(100)->create();
    }
}
