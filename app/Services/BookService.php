<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookService
{
    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }
    public function show(string $token): array
    {
        $find = $this->book->select("name","year")->where('token', $token)->firstOrFail();

        return ['data' => ['items' => $find->toArray(), 'totalCount' => 1]];
    }
    public function index(): array
    {
        $data = [
            'items' => $this->book->select("name","year")->get(),
            'totalCount' => $this->book->count(),
        ];

        return [$data];
    }

    public function store(Request $request): array
    {
        $dataFrom = $request->all();
        $dataFrom['token'] = Str::uuid()->toString();

            $data = $this->book->create($dataFrom);
        return ['data' => $data->toArray()];
    }
    public function update(Request $request, string $token): array
    {

        $data = $this->book->where('token', $token)->firstOrFail();
        $dataFrom = $request->all();
        $data->update($dataFrom);

        return ['data' => $dataFrom];
    }
    public function destroy(string $token): void
    {
        $data = $this->book->where('token', $token)->firstOrFail();
        $data->delete();
    }
}
