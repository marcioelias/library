<?php

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library() {
        $response = $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Eu mesmo'
        ]);

        $this->assertCount(1, Book::all());

        $response->assertRedirect('/books');
    }

    public function test_a_title_is_required() {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Eu mesmo'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_a_author_is_required() {
        $response = $this->post('/books', [
            'title' => 'A Cool title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_update() {
        $this->post('/books', [
            'title' => 'A Cool title',
            'author' => 'Eu mesmo'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect('/books');
    }

    public function test_a_book_can_be_deleted() {
        $this->post('/books', [
            'title' => 'A Cool title',
            'author' => 'Eu mesmo'
        ]);

        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete('/books/'.$book->id);

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
