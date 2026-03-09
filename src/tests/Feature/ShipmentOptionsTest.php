<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentOptionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_it_returns_successful_response_for_valid_input(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Standard&shipment_date=2026-03-25');

        $response->assertOk();
    }

    public function test_it_returns_available_shipment_options_for_valid_weekday_shipment(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Standard&shipment_date=2026-03-25');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'carrier',
                        'package',
                        'region',
                        'weekends',
                        'price',
                    ],
                ],
                'meta' => [
                    'count',
                ],
            ]);
    }

    public function test_it_returns_validation_error_for_invalid_country(): void
    {
        $response = $this->getJson('/api/shipment-options?country=ZZ&package_type=Standard&shipment_date=2026-03-25');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['country']);
    }

    public function test_it_returns_validation_error_for_invalid_package_type(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=InvalidType&shipment_date=2026-03-25');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['package_type']);
    }

    public function test_it_returns_validation_error_for_invalid_date(): void
    {
        $response = $this->getJson('/api/shipment-options?country=BE&package_type=Standard&shipment_date=invalid_date');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['shipment_date']);
    }

    public function test_it_requires_at_least_one_parameter_if_that_is_part_of_the_validation_rules(): void
    {
        $response = $this->getJson('/api/shipment-options');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['parameters']);
    }

    public function test_it_excludes_weekend_unavailable_options_for_weekend_shipments(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Mailbox&shipment_date=2026-03-29');

        $response->assertOk();

        $data = $response->json('data');

        $this->assertNotEmpty($data);

        foreach ($data as $option) {
            $this->assertTrue($option['weekends']);
        }
    }

    public function test_it_returns_postnl_standard_option_for_nl(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Standard&shipment_date=2026-03-25');

        $response->assertOk()
            ->assertJsonFragment([
                'carrier' => 'PostNL',
                'package' => 'Standard',
                'region' => 'NL',
                'price' => 6.95,
            ]);
    }

    public function test_it_excludes_non_weekend_carriers_on_weekend(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Pallet&shipment_date=2026-03-29');

        $response->assertOk();

        $data = $response->json('data');

        $this->assertNotEmpty($data);

        foreach ($data as $option) {
            $this->assertTrue($option['weekends']);
        }
    }

    public function test_response_has_expected_structure(): void
    {
        $response = $this->getJson('/api/shipment-options?country=NL&package_type=Standard&shipment_date=2026-03-25');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'carrier',
                        'package',
                        'region',
                        'weekends',
                        'price',
                    ]
                ]
            ]);
    }
}
