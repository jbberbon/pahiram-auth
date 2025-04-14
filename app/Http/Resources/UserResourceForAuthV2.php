<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceForAuthV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'apcId' => $this->apc_id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
        ];
    }
}
