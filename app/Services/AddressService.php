<?php

namespace App\Services;

use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressService
{
    protected $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    public function show(string $token): array
    {
        $find = $this->address->select('address', 'latitude', 'longitude', 'token')->where('token', $token)->firstOrFail();

        return ['data' => ['items' => $find->toArray(), 'totalCount' => 1]];
    }
    public function index(): array
    {
        $data = [
            'items' => $this->address->select("address", "latitude", "longitude", "token")->get(),
            'totalCount' => $this->address->count(),
        ];

        return [$data];
    }

    public function store(Request $request): array
    {
        $dataFrom = $request->all();
        $dataFrom['token'] = Str::uuid()->toString();

            $data = $this->address->create($dataFrom);
        return ['data' => $data->toArray()];
    }
    public function update(Request $request, string $token): array
    {

        $data = $this->address->where('token', $token)->firstOrFail();
        $dataFrom = $request->all();
        $data->update($dataFrom);

        return ['data' => $dataFrom];
    }
    public function destroy(string $token): void
    {
        $data = $this->address->where('token', $token)->firstOrFail();
        $data->delete();
    }
}
