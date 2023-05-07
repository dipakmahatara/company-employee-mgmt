<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_companies_api_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/companies');
        $response->assertStatus(200);
    }

    public function test_creating_a_valid_company_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/companies', ['name' => 'Abc Company Ltd', 'email' => 'name@abc.com', 'website' => 'https://abc.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Company Created Successfully!!',
            ]);
    }

    public function test_updating_a_valid_company_returns_a_successful_response(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $response = $this->actingAs($user)->patchJson('/api/companies/' . $company->id, ['name' => 'Apple Inc', 'email' => 'name@apple.com', 'website' => 'https://apple.com']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Company Updated Successfully!!',
            ]);
    }

    public function test_creating_an_invalid_company_returns_error_response(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/companies', ['name' => '', 'email' => 'user@company.com', 'website' => 'https://company.com']);

        $response->assertStatus(422);
    }

    public function test_creating_a_company_with_duplicate_email_returns_error_response(): void
    {
        $user = User::factory()->create();
        $company = ['name' => 'My Company Ltd', 'email' => 'user@company.com', 'website' => 'https://company.com'];
        Company::create($company);
        $response = $this->actingAs($user)->postJson('/api/companies', $company);
        $response->assertStatus(422);
    }

    public function test_pagination_works()
    {
        $itemsPerPage = 10;

        // Create sample data
        Company::factory()->count(50)->create();

        // Make a request to the API
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/api/companies?page=2&per_page=' . $itemsPerPage);

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

    public function test_deleting_a_company_returns_success_response(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $response = $this->actingAs($user)->deleteJson('/api/companies/' . $company->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Company Deleted Successfully!!'
            ]);
    }
}
