<?php

namespace Tests\Unit;

use App\Services\ShipmentOptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentOptionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ShipmentOptionService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->service = new ShipmentOptionService();
    }

    public function test_returns_empty_collection_when_no_filters_provided(): void
    {
        $result = $this->service->getShipmentOptions(null, null, null);

        $this->assertTrue($result->isEmpty());
    }

    public function test_returns_options_filtered_by_country(): void
    {
        $result = $this->service->getShipmentOptions('NL', null, null);

        $this->assertNotEmpty($result);

        $this->assertTrue($result->every(function ($row) {
            return $row->region->code === 'NL';
        }));
    }

    public function test_returns_options_filtered_by_package_type(): void
    {
        $result = $this->service->getShipmentOptions('NL', null, 'Standard');

        $this->assertNotEmpty($result);

        $this->assertTrue($result->every(function ($row) {
            return $row->package->name === 'Standard';
        }));
    }

    public function test_returns_only_weekend_available_options_for_weekend_date(): void
    {
        $result = $this->service->getShipmentOptions('BE', '2026-03-29', 'Mailbox'); // Sunday

        $this->assertNotEmpty($result);

        $this->assertTrue($result->every(function ($row) {
            return (bool) $row->weekends === true;
        }));
    }

    public function test_returns_postnl_standard_for_nl_weekday(): void
    {
        $result = $this->service->getShipmentOptions('NL', '2026-03-25', 'Standard');

        $this->assertTrue($result->contains(function ($row) {
            return $row->carrier->name === 'PostNL'
                && $row->package->name === 'Standard'
                && $row->region->code === 'NL'
                && (float) $row->price === 6.95;
        }));
    }
}
