<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class DevicesExport implements FromCollection
{
    public function collection()
    {
        return DB::table('devices')->get();
    }
}