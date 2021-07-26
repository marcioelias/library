<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'dob' => 'date|required'
        ]);

        Author::create($data);
    }
}
