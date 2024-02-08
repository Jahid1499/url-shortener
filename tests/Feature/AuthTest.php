<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_redirects_to_products()
    {
        User::create([
            'name'=>'jahid',
            'email'=>'jahid@gmail.com',
            'password'=>bcrypt('12345678')
        ]);

        $response = $this->post('/login', [
            'email'=> 'jahid@gmail.com',
            'password'=> '12345678'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('home');

    }

    public function test_unauthenticated_user_cannot_access_product(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
}
