<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\DevicesExport;

class ExportDevicesExcelController extends Controller
{
    function index()
    {
     $devices = DB::table('devices')->get();
     return view('export_excel_devices')->with('devices', $devices);
    }

    function excel()
    {
     $devices = DB::table('devices')->get()->toArray();
     $device_array[] = array('Device ID', 'Title', 'Description', 'Category', 'Filename', 'Downloads', 'Date Uploaded', 'Date Updated');
     foreach($devices as $device)
     {
      $device_array[] = array(
       'Device ID'  => $device->id,
       'IP'   => $device->ip,
       'Date Created'   => $device->created_at,
       'Date Updated'   => $device->updated_at,
      );
     }
     return Excel::download(new DevicesExport, 'devices.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}

?>