<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Worker;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\Validations\ValidationWorkerTrait;

class WorkerController extends Controller
{
    use ValidationWorkerTrait;

    public function get(int $id){

        $worker = Worker::with('company')->find($id);

        return $worker ? $this->response($worker, 200) : $this->response(null, 404);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), array_merge($this->getValidationRulesCompany(), $this->getValidationRulesWorker()));
        
        if ($validator->fails()) {
            return $this->response(null, 422, $validator->errors());
        }

        $validatedData = $validator->safe()->only(['firstName', 'lastName', 'email', 'phone']);

        $worker = new Worker();
        $worker->fill($validatedData);

        $company = Company::find($request->company_id);
        
        if (!$company) {
            return $this->response(null, 404);
        }
        
        $worker->company()->associate($company);

        $worker->save();

        return $this->response($worker, 201);
    }

    public function update(int $id, Request $request){

        $worker = Worker::find($id);

        if (!$worker) {
            return $this->response(null, 404, 'Not found company');
        }
        
        $validator = Validator::make($request->all(), $this->getValidationRulesWorker());
        
        if ($validator->fails()) {
            return $this->response(null, 422, $validator->errors());
        }

        $validatedData = $validator->safe()->only(['firstName', 'lastName', 'email', 'phone']);

        $worker->update($validatedData);

        return $this->response($worker, 200, 'Updated sucessfully');
    }
    
    public function delete(int $id){

        $worker = Worker::find($id);

        if (!$worker) {
            return $this->response(null, 404);
        }
    
        $worker->delete();

        return $this->response(null, 204);
    }
}