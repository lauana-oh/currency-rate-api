<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ConvertTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('dracma.driver', 'mock');
        Carbon::setTestNow('2021-11-27');
    }

    public function testItCanConvertARequest()
    {
        $response = $this->postJson('/api/convert', [
            [
                'from' => 'USD',
                'to' => 'BRL',
                'value' => 10
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('0', fn(AssertableJson $json) => $json
                ->where('from', 'USD')
                ->where('to', 'BRL')
                ->where('value', 10)
                ->where('quote', 5.67)
                ->where('result', 56.70)
                ->where('date', '2021-11-27')
            ));
    }

    public function testItCanConvertMultiplesRequest()
    {
        $response = $this->postJson('/api/convert', [
            [
                'from' => 'USD',
                'to' => 'BRL',
                'value' => 10
            ],
            [
                'from' => 'BRL',
                'to' => 'CLP',
                'value' => 10,
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('0', fn(AssertableJson $json) => $json
                ->where('from', 'USD')
                ->where('to', 'BRL')
                ->where('value', 10)
                ->where('quote', 5.67)
                ->where('result', 56.70)
                ->where('date', '2021-11-27')
            )->has('1', fn(AssertableJson $json) => $json
                ->where('from', 'BRL')
                ->where('to', 'CLP')
                ->where('value', 10)
                ->where('quote', 146.746)
                ->where('result', 1467)
                ->where('date', '2021-11-27')
            ));
    }
}
