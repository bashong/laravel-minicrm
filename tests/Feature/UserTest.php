<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Company;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
    * A basic unit test example.
    *
    * @return void
    */
    public function actingAdmin() : void{
        $this->actingAs(factory(User::class)->create());
    }

    public function testIfLoggedInToSeeCompaniesList(){
        $response = $this->get('/companies')->assertRedirect('/login');
    }

    public function testIfAuthenticatedUserToSeeCompaniesList(){
        $this->actingAdmin();
        $response = $this->get('/companies')->assertStatus(200);
    }

    public function testIfCompanyCanBeStored(){
        $this->actingAdmin();

        $response = $this->post(route('companies.store'), $this->data());

        $this->assertCount(1, Company::all());
    }

    public function testNameIsRequired()
    {
        $this->actingAdmin();

        $response = $this->post(route('companies.store'), array_merge($this->data(),['name'=>null]));

        $this->assertCount(0, Company::all());
    }

    private function data()
    {
        return [
            'name' => 'HAKABE',
            'email' => 'hakabe@email.com',
            'website' => 'http://hakabe.com',
            'address' => 'sa may pasay',
            'creator_id' => 1,
        ];
    }
}