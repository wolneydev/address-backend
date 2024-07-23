<?php

namespace App\Services;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarroService
{
    protected $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro;
    }
    public function show(string $token): array
    {
        $find = $this->carro->select("ano","nome")->where('token', $token)->firstOrFail();

        return ['data' => ['items' => $find->toArray(), 'totalCount' => 1]];
    }
    public function index(): array
    {
        $data = [
            'items' => $this->carro->select("ano","nome")->get(),
            'totalCount' => $this->carro->count(),
        ];

        return [$data];
    }

    public function store(Request $request): array
    {
        $dataFrom = $request->all();
        $dataFrom['token'] = Str::uuid()->toString();

            $data = $this->carro->create($dataFrom);
        return ['data' => $data->toArray()];
    }
    public function update(Request $request, string $token): array
    {

        $data = $this->carro->where('token', $token)->firstOrFail();
        $dataFrom = $request->all();
        $data->update($dataFrom);

        return ['data' => $dataFrom];
    }
    public function destroy(string $token): void
    {
        $data = $this->carro->where('token', $token)->firstOrFail();
        $data->delete();
    }
}
