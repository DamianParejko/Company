<?php

namespace App\Traits\Validations;

trait ValidationCompanyTrait 
{
    protected function getValidationRulesCompany(){
        return [
            'name' => 'required|min:2',
            'NIP' => 'required|digits:10',
            'address' => 'required|min:2',
            'city' => 'required|min:2',
            'postCode' => 'required|min:5',
            
        ];
    }    

    protected function getValidationRulesWorker()
    {
        return [
            'workers' => 'required|array|min:1',
            'workers.*.firstName' => 'required|min:2',
            'workers.*.lastName' => 'required|min:2',
            'workers.*.email' => 'required|email',
            'workers.*.phone' => 'nullable|min:8',
        ];
    }
}
