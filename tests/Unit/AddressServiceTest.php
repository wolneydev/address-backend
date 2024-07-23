<?php

namespace Tests\Unit\Services;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class AddressServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $addressService;

    public function setUp(): void
    {
        parent::setUp();

        $this->addressService = app(\App\Services\AddressService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeAddress = Address::factory()->create(['token' => $fakeToken]);

        $result = $this->addressService->show($fakeToken);

        $expectedData = [
            'address' => $fakeAddress->address,
            'latitude' => (string) $fakeAddress->latitude,
            'longitude' => (string) $fakeAddress->longitude,
            'token' => $fakeAddress->token,
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

        $fakeAddresses = Address::factory(3)->create();

        $result = $this->addressService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(Address::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewAddress()
    {
        $fakeStoreData = [
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->addressService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesAddress()
    {
        $fakeToken = $this->faker->uuid;
        $fakeAddress = \App\Models\Address::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->addressService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('address', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesAddress()
    {
        $fakeToken = $this->faker->uuid;
        $fakeAddress = Address::factory()->create(['token' => $fakeToken]);

        $this->addressService->destroy($fakeToken);

        $this->assertDatabaseMissing('address', ['token' => $fakeToken]);
    }
}
