<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipmentOptionsRequest;
use App\Http\Resources\ShipmentOptionResource;
use App\Services\ShipmentOptionService;
use Illuminate\Http\Request;


class ShipmentOptionsController extends Controller
{
    private ShipmentOptionService $service;

    public function __construct(ShipmentOptionService $service)
    {
        $this->service = $service;
    }

    public function index(ShipmentOptionsRequest $request)
    {
        $shipmentOptions = $this->service->getShipmentOptions(
            $request->input('country'),
            $request->input('shipment_date'),
            $request->input('package_type'),
        );

/*
        $validated = $request->validate([
            'country'        => 'required|string|size:2',
            'shipment_date'  => 'required|date',
            'package_type'        => 'required|string',
        ]);
        $shipmentOptions = $this->service->getShipmentOptions(
            $validated['country'],
            $validated['shipment_date'],
            $validated['package_type']
        );*/

        //dd(get_class($shipmentOptions));
/*
        return response()->json([
            'data'  => ShipmentOptionResource::collection($shipmentOptions),
            'count' => $shipmentOptions->count(),
        ]);*/

        return ShipmentOptionResource::collection($shipmentOptions)
            ->additional([
                'meta' => [
                    'count' => $shipmentOptions->count(),
                ],
            ]);

    }
}


