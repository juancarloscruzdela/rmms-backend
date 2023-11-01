<!--
 export_excel.blade.php
!-->

<!DOCTYPE html>
<html>
 <head>
  <title>Export Data to Excel</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container">
   <h3 align="center">Export Data to Excel</h3><br />
   <div align="center">
    <a href="{{ route('export_excel_videos.excel') }}" class="btn btn-success">Export to Excel</a>
   </div>
   <br />
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <tr>
      <td>Video ID</td>
      <td>Title</td>
      <td>Description</td>
      <td>Category</td>
      <td>Filename</td>
      <td>Views</td>
      <td>Date Uploaded</td>
      <td>Date Updated</td>
     </tr>
     @foreach($videos as $video)
     <tr>
      <td>{{ $video->id }}</td>
      <td>{{ $video->title }}</td>
      <td>{{ $video->description }}</td>
      <td>{{ $video->category }}</td>
      <td>{{ $video->file }}</td>
      <td>{{ $video->views }}</td>
      <td>{{ $video->created_at }}</td>
      <td>{{ $video->updated_at }}</td>
     </tr>
     @endforeach
    </table>
   </div>
   
  </div>
 </body>
</html>