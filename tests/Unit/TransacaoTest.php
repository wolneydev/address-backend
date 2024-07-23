<?php

namespace Tests\Unit\Services;

use App\Models\Transacao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class TransacaoServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $transacaoService;

    public function setUp(): void
    {
        parent::setUp();

        $this->transacaoService = app(\App\Services\TransacaoService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeTransacao = Transacao::factory()->create(['token' => $fakeToken]);

        $result = $this->transacaoService->show($fakeToken);

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

        $fakeTransacaoes = Transacao::factory(3)->create();

        $result = $this->transacaoService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(Transacao::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewTransacao()
    {
        $fakeStoreData = [
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->transacaoService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesTransacao()
    {
        $fakeToken = $this->faker->uuid;
        $fakeTransacao = \App\Models\Transacao::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->transacaoService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('transacao', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesTransacao()
    {
        $fakeToken = $this->faker->uuid;
        $fakeTransacao = Transacao::factory()->create(['token' => $fakeToken]);

        $this->transacaoService->destroy($fakeToken);

        $this->assertDatabaseMissing('transacao', ['token' => $fakeToken]);
    }
}
