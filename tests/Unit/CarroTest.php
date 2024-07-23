<?php

namespace Tests\Unit\Services;

use App\Models\Carro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class CarroServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $carroService;

    public function setUp(): void
    {
        parent::setUp();

        $this->carroService = app(\App\Services\CarroService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeCarro = Carro::factory()->create(['token' => $fakeToken]);

        $result = $this->carroService->show($fakeToken);

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

        $fakeCarroes = Carro::factory(3)->create();

        $result = $this->carroService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(Carro::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewCarro()
    {
        $fakeStoreData = [
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->carroService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesCarro()
    {
        $fakeToken = $this->faker->uuid;
        $fakeCarro = \App\Models\Carro::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->carroService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('carro', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesCarro()
    {
        $fakeToken = $this->faker->uuid;
        $fakeCarro = Carro::factory()->create(['token' => $fakeToken]);

        $this->carroService->destroy($fakeToken);

        $this->assertDatabaseMissing('carro', ['token' => $fakeToken]);
    }
}
