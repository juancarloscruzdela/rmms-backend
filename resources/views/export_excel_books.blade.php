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
    <a href="{{ route('export_excel_books.excel') }}" class="btn btn-success">Export to Excel</a>
   </div>
   <br />
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <tr>
      <td>Book ID</td>
      <td>Title</td>
      <td>Description</td>
      <td>Category</td>
      <td>Filename</td>
      <td>Downloads</td>
      <td>Date Uploaded</td>
      <td>Date Updated</td>
     </tr>
     @foreach($books as $book)
     <tr>
      <td>{{ $book->id }}</td>
      <td>{{ $book->title }}</td>
      <td>{{ $book->description }}</td>
      <td>{{ $book->category }}</td>
      <td>{{ $book->file }}</td>
      <td>{{ $book->downloads }}</td>
      <td>{{ $book->created_at }}</td>
      <td>{{ $book->updated_at }}</td>
     </tr>
     @endforeach
    </table>
   </div>
   
  </div>
 </body>
</html>