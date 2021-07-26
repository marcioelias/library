<?php

namespace Tests\Unit;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    public function test_an_author_can_be_created() {
        $this->withoutExceptionHandling();
        $this->post('/authors', [
            'name' => 'Author',
            'dob' => '01/31/1998'
        ]);

        $authors = Author::all();
        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals('31/01/1998', $authors->first()->dob->format('d/m/Y'));
    }
}
