<?php

namespace Tests\Unit\Services;

use App\Models\SubwayLines;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;

class SubwayLinesServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $subwaylinesService;

    public function setUp(): void
    {
        parent::setUp();

        $this->subwaylinesService = app(\App\Services\SubwayLinesService::class);
    }

    public function testShowMethodReturnsCorrectData()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubwayLines = SubwayLines::factory()->create(['token' => $fakeToken]);

        $result = $this->subwaylinesService->show($fakeToken);

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

        $fakeSubwayLineses = SubwayLines::factory(3)->create();

        $result = $this->subwaylinesService->index();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result['data']['items']);

        $this->assertCount(3, $result['data']['items']);

        foreach ($result['data']['items'] as $item) {
            $this->assertInstanceOf(SubwayLines::class, $item);
        }

        $this->assertEquals(3, $result['data']['totalCount']);
    }



    public function testStoreMethodCreatesNewSubwayLines()
    {
        $fakeStoreData = [
        ];
        $fakeRequest = new Request($fakeStoreData);
        $result = $this->subwaylinesService->store($fakeRequest);
        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
    }


    public function testUpdateMethodUpdatesSubwayLines()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubwayLines = \App\Models\SubwayLines::factory()->create(['token' => $fakeToken]);

        $fakeUpdateData = [
        ];
        $fakeRequest = new Request($fakeUpdateData);
        $result = $this->subwaylinesService->update($fakeRequest, $fakeToken);

        $this->assertDatabaseHas('subwaylines', $fakeUpdateData);
        $this->assertEquals(['data' => $fakeUpdateData], $result);
    }

    public function testDestroyMethodDeletesSubwayLines()
    {
        $fakeToken = $this->faker->uuid;
        $fakeSubwayLines = SubwayLines::factory()->create(['token' => $fakeToken]);

        $this->subwaylinesService->destroy($fakeToken);

        $this->assertDatabaseMissing('subwaylines', ['token' => $fakeToken]);
    }
}
