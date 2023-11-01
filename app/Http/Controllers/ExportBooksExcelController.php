<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\BooksExport;

class ExportBooksExcelController extends Controller
{
    function index()
    {
     $books = DB::table('books')->get();
     return view('export_excel_books')->with('books', $books);
    }

    function excel()
    {
     $books = DB::table('books')->get()->toArray();
     $book_array[] = array('Book ID', 'Title', 'Description', 'Category', 'Filename', 'Downloads', 'Date Uploaded', 'Date Updated');
     foreach($books as $book)
     {
      $book_array[] = array(
       'Book ID'  => $book->id,
       'Title'   => $book->title,
       'Description'    => $book->description,
       'Category'  => $book->category,
       'Filename'   => $book->file,
       'Downloads'   => $book->downloads,
       'Date Uploaded'   => $book->created_at,
       'Date Updated'   => $book->updated_at,
      );
     }
     return Excel::download(new BooksExport, 'books.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}

?>