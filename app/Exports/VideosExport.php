<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class VideosExport implements FromCollection
{
    public function collection()
    {
        return DB::table('videos')->get();
    }
}