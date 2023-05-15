<?php

namespace App\Traits\Validations;

trait ValidationWorkerTrait 
{
    protected function getValidationRulesCompany(){
        return [
            'company_id' => 'required|exists:companies,id'
        ];
    }

    protected function getValidationRulesWorker()
    {
        return [
            'firstName' => 'required|min:2',
            'lastName' => 'required|min:2',
            'email' => 'required|email',
            'phone' => 'nullable|min:8',
        ];
    }
}