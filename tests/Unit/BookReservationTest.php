<?php

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library() {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Eu mesmo'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
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
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A Cool title',
            'author' => 'Eu mesmo'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $response->assertOk();
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
