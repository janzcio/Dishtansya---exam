<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        $response = $this->post('/api/register', [
            'name' => 'Name 1',
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123',
            'password_confirmation' => 'test123',
        ]);

        // Artisan::call('migrate');

        $response->assertStatus(201);
    }

    public function test_register_duplicate_email()
    {
        $response = $this->post('/api/register', [
            'name' => 'Name 1',
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123',
            'password_confirmation' => 'test123',
        ]);

        $response->assertStatus(400);
    }

    public function test_new_registered_user_can_login()
    {
        $response = $this->post('/api/login', [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ]);
        $decoded_response = $response->json();

        $response->assertStatus(201);
    }
    
    public function test_if_user_using_invalid_crendential()
    {
        $response = $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $response->assertStatus(401);
    }

    public function test_if_user_using_invalid_crendential_too_many_attempts()
    {
        $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $response = $this->post('/api/login', [
            'email' => 'backend@multisyscorpx.com',
            'password' => 'test123'
        ]);

        $response->assertStatus(429);
    }

    public function test_user_can_order()
    {
        $logInResponse = $this->post('/api/login', [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ]);
        $decoded_response = $logInResponse->json();

        $response = $this->post('/api/order', [
            'product_id' => '1',
            'quantity' => '1'
        ],[
            'Authorization' => 'Bearer ' . $decoded_response["access_token"]
        ]);

        $response->assertStatus(201);
    }

    public function test_user_order_out_of_stock()
    {
        $logInResponse = $this->post('/api/login', [
            'email' => 'backend@multisyscorp.com',
            'password' => 'test123'
        ]);
        $decoded_response = $logInResponse->json();

        $response = $this->post('/api/order', [
            'product_id' => 1,
            'quantity' => 20
        ],[
            'Authorization' => 'Bearer ' . $decoded_response["access_token"]
        ]);
        
        $response->assertStatus(400);
    }

}
