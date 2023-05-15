<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Worker;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
    }

    public function test_get_company()
    {
        $worker = Worker::factory()->companyId($this->company->id)->create();

        $response = $this->json('GET', '/api/workers/' . $worker->id);

        $response->assertStatus(200);
    }

    public function test_update_company()
    {
        $worker = Worker::factory()->companyId($this->company->id)->create();
       
        $response = $this->json('PUT', '/api/workers/' . $worker->id, $worker->attributesToArray());

        $response->assertStatus(200);
    }

    public function test_delete_company()
    {
        $worker = Worker::factory()
            ->count(1)
            ->companyId($this->company->id)
            ->create();

        $response = $this->delete('/api/workers/' . $worker->first()->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('workers', [
            'id' => $worker->first()->id
        ]);
    }
}

