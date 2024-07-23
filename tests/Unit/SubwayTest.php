<?php

namespace Tests\Unit\Services;

use App\Models\Subway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class SubwayServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $subwayService;

    public function setUp(): void
    {
        parent::setUp();

        $this->subwayService = app(\App\Services\SubwayService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubway = Subway::factory()->create(['token' => $fakeToken]);

        $result = $this->subwayService->show($fakeToken);

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

        $fakeSubwayes = Subway::factory(3)->create();

        $result = $this->subwayService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(Subway::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewSubway()
    {
        $fakeStoreData = [
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->subwayService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesSubway()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubway = \App\Models\Subway::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->subwayService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('subway', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesSubway()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubway = Subway::factory()->create(['token' => $fakeToken]);

        $this->subwayService->destroy($fakeToken);

        $this->assertDatabaseMissing('subway', ['token' => $fakeToken]);
    }
}
