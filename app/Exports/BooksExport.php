<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class BooksExport implements FromCollection
{
    public function collection()
    {
        return DB::table('books')->get();
    }
}