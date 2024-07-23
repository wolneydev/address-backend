<?php

namespace App\Services;

use App\Models\Subway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubwayService
{
    protected $subway;

    public function __construct(Subway $subway)
    {
        $this->subway = $subway;
    }
    public function show(string $token): array
    {
        $find = $this->subway->select("address_id","name")->where('token', $token)->firstOrFail();

        return ['data' => ['items' => $find->toArray(), 'totalCount' => 1]];
    }
    public function index(): array
    {
        $data = [
            'items' => $this->subway->select("address_id","name","token","subwayline_id")->with(['subwayline','address'])->get(),
            'totalCount' => $this->subway->count(),
        ];

        return [$data];
    }

    public function store(Request $request): array
    {
        $dataFrom = $request->all();
        $dataFrom['token'] = Str::uuid()->toString();

            $data = $this->subway->create($dataFrom);
        return ['data' => $data->toArray()];
    }
    public function update(Request $request, string $token): array
    {

        $data = $this->subway->where('token', $token)->firstOrFail();
        $dataFrom = $request->all();
        $data->update($dataFrom);

        return ['data' => $dataFrom];
    }
    public function destroy(string $token): void
    {
        $data = $this->subway->where('token', $token)->firstOrFail();
        $data->delete();
    }
}
