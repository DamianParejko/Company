<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Worker;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\Validates\ValidationCompanyTrait;

class CompanyController extends Controller
{
    use ValidationCompanyTrait;

    public $paginateCount = 15;

    public function index(){

        $company = Company::with('workers')->paginate($this->paginateCount);

        return $this->response($company, 200);
    }

    public function get(int $id){

        $company = Company::find($id);

        return $company ? $this->response($company, 200) : $this->response(null, 404);
    }

    public function create(Request $request){
        
        try {
            DB::beginTransaction();

            $company = new Company();

            $validator = Validator::make($request->all(), array_merge($this->getValidationRulesCompany(), $this->getValidationRulesWorker()));
            
            if ($validator->fails()) {
                return $this->response(null, 422, $validator->errors());
            }

            $validatedDataCompany = $validator->safe()->only(['name', 'NIP', 'address', 'city', 'postCode']);

            $company = new Company();
            $company->fill($validatedDataCompany);
            $company->save();

            $validatedDataWorker = $validator->safe()->only(['workers', 'firstName', 'lastName', 'email', 'phone']);
            
            $this->createWorkers($company, $validatedDataWorker['workers']);

            DB::commit();

            return $this->response($company, 201);
        } catch(\Exception $e){
            DB::rollBack();
            return $this->response(null, 500, $e->getMessage());
        }
    }

    private function createWorkers($company, $workerData){

        foreach ($workerData as $workerItem) {
            $worker = new Worker();
            $worker->fill($workerItem);
            $company->workers()->save($worker);
        }
    }
    
    public function update(int $id, Request $request){

        $company = Company::find($id);

        if (!$company) {
            return $this->response(null, 404);
        }
    
        $validator = Validator::make($request->all(), $this->getValidationRulesCompany());
        
        if ($validator->fails()) {
            return $this->response(null, 422, $validator->errors());
        }
        
        $validatedData = $validator->safe()->only(['name', 'NIP', 'address', 'city', 'postCode']);
    
        $company->update($validatedData);

        return $this->response($company, 200, 'Updated successfully');
    }

    public function delete(int $id){

        $company = Company::find($id);

        if (!$company) {
            return $this->response(null, 404);
        }
    
        $company->delete();

        return $this->response(null, 204);
    }
}