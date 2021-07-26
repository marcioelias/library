<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(Request $request) {
        Book::create($this->validateRequest($request));
        return redirect('/books');
    }

    public function update(Request $request, Book $book) {
        $book->update($this->validateRequest($request));
        return redirect('/books');
    }

    public function destroy(Book $book) {
        $book->delete();

        return redirect('/books');
    }

    protected function validateRequest(Request $request) {
        return $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
