<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at', 'desc')->limit(12)->get();
        
        return view('home', compact('books'));
    }
}
