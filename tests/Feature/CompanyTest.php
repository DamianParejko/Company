<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Worker;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_all_company()
    {
        $response = $this->json('GET', '/api/companies');

        $response->assertStatus(200);
    }

    public function test_get_company()
    {
        $company = Company::factory()->create();

        $response = $this->json('GET', '/api/companies/' . $company->id);

        $response->assertStatus(200);
    }
    
    public function test_create_company()
    {
        $company = Company::factory()->create();

        $workerData = Worker::factory()
            ->count(1)
            ->companyId($company->id)
            ->create()
            ->toArray();

        $requestData = array_merge(
            $company->attributesToArray(),
            ['workers' => $workerData]
        );

        $response = $this->json('POST', '/api/companies', $requestData);

        $response->assertStatus(201);
    }

    public function test_update_company()
    {
        $company = Company::factory()->create();
       
        $response = $this->json('PUT', '/api/companies/' . $company->id, $company->attributesToArray());

        $response->assertStatus(200);
    }

    public function test_delete_company()
    {
        $company = Company::factory()->create();

        $worker = Worker::factory()
            ->count(1)
            ->companyId($company->id)
            ->create();

        $response = $this->delete('/api/companies/' . $company->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', [
            'id' => $company->id
        ]);

        $this->assertDatabaseMissing('workers', [
            'id' => $worker->first()->id
        ]);
    }

}