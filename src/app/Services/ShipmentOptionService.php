<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Package;
use App\Models\ShipmentOption;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ShipmentOptionService
{
    /**
     * Returns all available shipment options based on country, shipment date
     * and package type. Applies business rules such as region mapping
     * and weekend availability.
     *
     * @param string|null $countryCode   ISO country code (e.g. NL, BE, FR)
     * @param string|null $shipmentDate  Shipment date (Y-m-d)
     * @param string|null $packageName   Package type (Standard, Mailbox, Pallet)
     *
     * @return \Illuminate\Support\Collection
     */

    public function getShipmentOptions(?string $countryCode, ?string $shipmentDate, ?string $packageName): Collection
    {
        if(is_null($countryCode) && is_null($shipmentDate) && is_null($packageName)) {
            return collect();
        }

        // Get region by country
        $region = null;
        if($countryCode){
            $country = Country::where('code', strtoupper($countryCode))->first();
                if($country)
                {
                    $region = $country->region;
                }
        }

        // Get package
        $package = null;
        if($packageName){
            $package = Package::where('name', $packageName)->first();
        }

        // Build query
        $query = ShipmentOption::with(['carrier', 'package', 'region']);

        if($region){
            $query->where('region_id', $region->id);
        }
        if($package){
            $query->where('package_id', $package->id);
        }
        if($shipmentDate){
            $date = Carbon::parse($shipmentDate);
            $isWeekend = $date->isWeekend();

            if($isWeekend){
                $query->where('weekends', true);
            }
        }

        // dd($query->toSql(), $query->getBindings());

        return $query->get();

    }

}



