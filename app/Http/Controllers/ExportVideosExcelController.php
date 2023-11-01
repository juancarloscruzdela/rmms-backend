<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\VideosExport;

class ExportVideosExcelController extends Controller
{
    function index()
    {
     $videos = DB::table('videos')->get();
     return view('export_excel_videos')->with('videos', $videos);
    }

    function excel()
    {
     $videos = DB::table('videos')->get()->toArray();
     $video_array[] = array('Video ID', 'Title', 'Description', 'Category', 'Filename', 'Views', 'Date Uploaded', 'Date Updated');
     foreach($videos as $video)
     {
      $video_array[] = array(
       'Video ID'  => $video->id,
       'Title'   => $video->title,
       'Description'    => $video->description,
       'Category'  => $video->category,
       'Filename'   => $video->file,
       'Views'   => $video->views,
       'Date Uploaded'   => $video->created_at,
       'Date Updated'   => $video->updated_at,
      );
     }
     return Excel::download(new VideosExport, 'videos.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}

?>