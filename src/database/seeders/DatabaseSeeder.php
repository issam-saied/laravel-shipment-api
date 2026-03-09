<?php

namespace database\seeders;

use App\Models\Carrier;
use App\Models\Country;
use App\Models\Package;
use App\Models\Region;
use App\Models\ShipmentOption;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Current timestamp
        $now = now();

        // Seed Carriers
        Carrier::insert([
            ['name' => 'PostNL', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'DHL', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'DPD', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UPS', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed Package Types
        Package::insert([
            ['name' => 'Standard', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Mailbox', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pallet', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed Regions
        Region::insert([
            ['code' => 'NL', 'name' => 'Netherlands', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'BE', 'name' => 'Belgium', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'EU', 'name' => 'Europe', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ROW', 'name' => 'Rest of World', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed Countries
        Country::insert([
            ['code' => 'NL', 'name' => 'Netherlands', 'region_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'BE', 'name' => 'Belgium', 'region_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'FR', 'name' => 'France', 'region_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DE', 'name' => 'Germany', 'region_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'US', 'name' => 'United States', 'region_id' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed Carrier Prices
        ShipmentOption::insert([
            // PostNL
            ['carrier_id' => 1, 'package_id' => 1, 'region_id' => 1, 'weekends' => true,  'price' => 6.95,  'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 2, 'region_id' => 1, 'weekends' => true,  'price' => 3.95,  'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 3, 'region_id' => 1, 'weekends' => false, 'price' => 26.95, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 1, 'region_id' => 2, 'weekends' => true,  'price' => 7.95,  'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 2, 'region_id' => 2, 'weekends' => true,  'price' => 4.95,  'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 1, 'region_id' => 3, 'weekends' => true,  'price' => 10.95, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 1, 'package_id' => 1, 'region_id' => 4, 'weekends' => false, 'price' => 13.95, 'created_at' => $now, 'updated_at' => $now],

            // DHL
            ['carrier_id' => 2, 'package_id' => 1, 'region_id' => 1, 'weekends' => true, 'price' => 7.45, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 2, 'package_id' => 2, 'region_id' => 1, 'weekends' => true, 'price' => 4.45, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 2, 'package_id' => 1, 'region_id' => 2, 'weekends' => true, 'price' => 8.45, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 2, 'package_id' => 2, 'region_id' => 2, 'weekends' => true, 'price' => 5.45, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 2, 'package_id' => 1, 'region_id' => 3, 'weekends' => false, 'price' => 10.45, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 2, 'package_id' => 1, 'region_id' => 4, 'weekends' => false, 'price' => 12.45, 'created_at' => $now, 'updated_at' => $now],

            // DPD
            ['carrier_id' => 3, 'package_id' => 1, 'region_id' => 1, 'weekends' => true, 'price' => 7.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 2, 'region_id' => 1, 'weekends' => false, 'price' => 4.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 3, 'region_id' => 1, 'weekends' => true, 'price' => 21.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 1, 'region_id' => 2, 'weekends' => true, 'price' => 8.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 2, 'region_id' => 2, 'weekends' => false, 'price' => 5.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 3, 'region_id' => 2, 'weekends' => true, 'price' => 23.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 1, 'region_id' => 3, 'weekends' => false, 'price' => 10.75, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 3, 'package_id' => 1, 'region_id' => 4, 'weekends' => false, 'price' => 12.75, 'created_at' => $now, 'updated_at' => $now],

            // UPS
            ['carrier_id' => 4, 'package_id' => 2, 'region_id' => 1, 'weekends' => false, 'price' => 4.25, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 4, 'package_id' => 2, 'region_id' => 2, 'weekends' => false, 'price' => 5.25, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 4, 'package_id' => 2, 'region_id' => 3, 'weekends' => false, 'price' => 6.25, 'created_at' => $now, 'updated_at' => $now],
            ['carrier_id' => 4, 'package_id' => 2, 'region_id' => 4, 'weekends' => false, 'price' => 8.25, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
