<?php

namespace Tests\Unit\Services;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $bookService;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookService = app(\App\Services\BookService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeBook = Book::factory()->create(['token' => $fakeToken]);

        $result = $this->bookService->show($fakeToken);

        $expectedData = [
        ];

        $this->assertEquals([
            'data' => [
                'items' => $expectedData,
                'totalCount' => 1,
            ],
        ], $result);
    }

    public function testIndexMethodReturnsCorrectData()
    {

        $fakeBookes = Book::factory(3)->create();

        $result = $this->bookService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(Book::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewBook()
    {
        $fakeStoreData = [
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->bookService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesBook()
    {
        $fakeToken = $this->faker->uuid;
        $fakeBook = \App\Models\Book::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->bookService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('book', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesBook()
    {
        $fakeToken = $this->faker->uuid;
        $fakeBook = Book::factory()->create(['token' => $fakeToken]);

        $this->bookService->destroy($fakeToken);

        $this->assertDatabaseMissing('book', ['token' => $fakeToken]);
    }
}
