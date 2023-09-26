<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;


class FormController extends Controller
{
    //
    public function index(){
        return view('form');
    }

    public function validation(Request $request){
        $validatedData = $request->validate([
            'title' => ['required', 'max:255'],
            'isbn' => ['required', 'min:3'],
            'author' => ['required', 'max:255'],
            'Year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:'.(date('Y')+1)],
            'price' => ['required', 'numeric', 'between:2.50,99.99'],
            'image' => ['required', 'max:2048', 'mimes:jpg,jpeg,png']
        ]);
        // Book::create($validatedData);
        if($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('images');
        }

        return redirect('/show')->with(['book' => $validatedData,'status' => 'success New Book Have Been Added!','message' => 'New Book Have Been Added!']);
    }
    // $book = $validatedData,
    
    public function show(){
        $books = session()->get('book');
        
        return view('show',[
            'books' => $books
        ]);
    }
}
