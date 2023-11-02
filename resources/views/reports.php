<!--
 export_excel.blade.php
!-->

<!DOCTYPE html>
<html>
 <head>
  <title>Reports</title>
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
   <h3 align="center">Reports</h3><br />
   <div align="center">
    <a href="/api/export_excel/videos" class="btn btn-info">Videos</a>
    <a href="/api/export_excel/books" class="btn btn-info">Books</a>
    <a href="/api/export_excel/devices" class="btn btn-info">Devices</a>
   </div>
   <br />
   
  </div>
 </body>
</html>