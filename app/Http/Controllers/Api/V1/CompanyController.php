<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyController extends Controller
{
    private function getValidationRules()
    {
        return [
            'name' => 'required|min:2',
            'NIP' => 'required|digits:10',
            'address' => 'required|min:2',
            'city' => 'required|min:2',
            'postCode' => 'required|digits:5'
        ];
    }

    public function index(){

        $company = Company::all();

        return $this->response($company, 200);
    }

    public function get(int $id){

        $company = Company::find($id);

        return $company ? $this->response($company, 200) : $this->response(null, 404);
    }

    public function create(Request $request){
        
        $company = new Company();

        $validator = Validator::make($request->all(), $this->getValidationRules());
        
        if ($validator->fails()) {
            return $this->response(null, 422, $validator->errors());
        }

        $validatedData = $validator->safe()->only(['name', 'NIP', 'address', 'city', 'postCode']);

        $company = new Company();
        $company->fill($validatedData);
        $company->save();
        
        return $this->response($company, 201);
    }
    
    public function update($id, Request $request){

        $company = Company::find($id);

        if (!$company) {
            return $this->response(null, 404);
        }
    
        $validator = Validator::make($request->all(), $this->getValidationRules());
        
        if ($validator->fails()) {
            return $this->response(null, 422, $validator->errors());
        }
        
        $validatedData = $validator->safe()->only(['name', 'NIP', 'address', 'city', 'postCode']);
    
        $company->update($validatedData);

        return $this->response($company, 200);
    }

    public function delete($id){

        $company = Company::find($id);

        if (!$company) {
            return $this->response(null, 404);
        }
    
        $company->delete();

        return $this->response(null, 204);
    }
}
