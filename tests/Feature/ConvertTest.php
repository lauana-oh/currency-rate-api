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
                'value' => 10,
            ],
        ]);

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(
                '0',
                fn (AssertableJson $json) => $json
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
                'value' => 10,
            ],
            [
                'from' => 'BRL',
                'to' => 'CLP',
                'value' => 10,
            ],
        ]);

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(
                '0',
                fn (AssertableJson $json) => $json
                ->where('from', 'USD')
                ->where('to', 'BRL')
                ->where('value', 10)
                ->where('quote', 5.67)
                ->where('result', 56.70)
                ->where('date', '2021-11-27')
            )->has(
                '1',
                fn (AssertableJson $json) => $json
                ->where('from', 'BRL')
                ->where('to', 'CLP')
                ->where('value', 10)
                ->where('quote', 146.746)
                ->where('result', 1467)
                ->where('date', '2021-11-27')
            ));
    }

    /**
     * @dataProvider invalidRequest
     */
    public function testItCanNotConvertIfRequestFormatIsInvalid(array $request, string $key, string $message)
    {
        $response = $this->postJson('/api/convert', $request);

        $response->assertUnprocessable();
        $this->assertEquals($message, $response['errors'][$key][0]);
    }

    public function invalidRequest(): array
    {
        $data = [
            [
                'from' => 'USD',
                'to' => 'BRL',
                'value' => 10,
            ],
        ];

        return [
            'from is missing' => [
                array_replace_recursive($data, [['from' => null]]),
                '0.from',
                'The 0.from field is required.',
            ],
            'from is not string' => [
                array_replace_recursive($data, [['from' => [null]]]),
                '0.from',
                'The 0.from must be a string.',
            ],
            'to is missing' => [
                array_replace_recursive($data, [['to' => null]]),
                '0.to',
                'The 0.to field is required.',
            ],
            'to is not string' => [
                array_replace_recursive($data, [['to' => [null]]]),
                '0.to',
                'The 0.to must be a string.',
            ],
            'value is missing' => [
                array_replace_recursive($data, [['value' => null]]),
                '0.value',
                'The 0.value field is required.',
            ],
            'value is not numeric' => [
                array_replace_recursive($data, [['value' => 'abd']]),
                '0.value',
                'The 0.value must be a number.',
            ],
            'date has invalid format' => [
                array_replace_recursive($data, [['date' => '2021-27']]),
                '0.date',
                'The 0.date does not match the format Y-m-d.',
            ],
        ];
    }
}
