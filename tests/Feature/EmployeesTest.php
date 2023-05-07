<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_employees_api_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/employees');
        $response->assertStatus(200);
    }

    public function test_creating_a_valid_employee_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/employees', ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@doe.com', 'phone' => 441234567890, 'company_id' => $company->id]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Employee Created Successfully!!',
            ]);
    }

    public function test_updating_a_valid_employee_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        Company::factory(10)->create();
        $employee = Employee::factory()->create();
        $response = $this->actingAs($user)->patchJson('/api/employees/' . $employee->id, ['first_name' => 'Random', 'last_name' => 'Doe', 'email' => 'random@doe.com', 'phone' => 441234567890, 'company_id' => $employee->company->id]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Employee Updated Successfully!!',
            ]);
    }


    public function test_creating_an_invalid_employee_returns_error_response(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/employees', ['first_name' => '', 'email' => 'user@gmail.com']);

        $response->assertStatus(422);
    }

    public function test_creating_a_employee_with_duplicate_email_returns_error_response(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $employee = ['first_name' => 'John', 'last_name' => 'Diesel',  'email' => 'user@gmail.com', 'phone' => 1234567890, 'company_id' => $company->id];
        Employee::create($employee);
        $response = $this->actingAs($user)->postJson('/api/employees', $employee);
        $response->assertStatus(422);
    }

    public function test_pagination_works()
    {
        $itemsPerPage = 10;

        // Create sample data
        Company::factory(10)->create();
        Employee::factory()->count(50)->create();

        // Make a request to the API
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/api/employees?page=2&per_page=' . $itemsPerPage);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonCount($itemsPerPage, 'data');
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'links' => [],
            'next_page_url',
            'path',
            'prev_page_url',
            'per_page',
            'total'
        ]);
    }

    public function test_deleting_a_employee_returns_success_response(): void
    {
        $user = User::factory()->create();
        Company::factory(4)->create();
        $employee = Employee::factory()->create();
        $response = $this->actingAs($user)->deleteJson('/api/employees/' . $employee->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Employee Deleted Successfully!!'
            ]);
    }
}
