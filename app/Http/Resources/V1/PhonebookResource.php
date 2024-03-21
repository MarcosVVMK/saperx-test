<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhonebookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'      =>  $this->name,
            'email'     =>  $this->email,
            'birthdate' =>  $this->birthdate,
            'CPF'       =>  $this->CPF,
            'phones'    =>  $this->phones
        ];
    }

    public function report(Request $request)
    {

    }
}