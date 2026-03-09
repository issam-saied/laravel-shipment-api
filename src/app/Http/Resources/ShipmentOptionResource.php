<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'carrier'      => $this->carrier->name,
            'package'      => $this->package->name,
            'region'       => $this->region->code,
            'weekends'     => (bool) $this->weekends,
            'price'        => (float) $this->price,
        ];
    }
}
