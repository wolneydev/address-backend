<?php

namespace App\Services;

use App\Models\SubwayLines;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubwayLinesService
{
    protected $subwaylines;

    public function __construct(SubwayLines $subwaylines)
    {
        $this->subwaylines = $subwaylines;
    }
    public function show(string $token): array
    {
        $find = $this->subwaylines->select("name")->where('token', $token)->firstOrFail();

        return ['data' => ['items' => $find->toArray(), 'totalCount' => 1]];
    }
    public function index(): array
    {
        $data = [
            'items' => $this->subwaylines->select("name","token")->get(),
            'totalCount' => $this->subwaylines->count(),
        ];

        return [$data];
    }

    public function store(Request $request): array
    {
        $dataFrom = $request->all();
        $dataFrom['token'] = Str::uuid()->toString();

            $data = $this->subwaylines->create($dataFrom);
        return ['data' => $data->toArray()];
    }
    public function update(Request $request, string $token): array
    {

        $data = $this->subwaylines->where('token', $token)->firstOrFail();
        $dataFrom = $request->all();
        $data->update($dataFrom);

        return ['data' => $dataFrom];
    }
    public function destroy(string $token): void
    {
        $data = $this->subwaylines->where('token', $token)->firstOrFail();
        $data->delete();
    }
}
