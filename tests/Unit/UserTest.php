<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
 
    public function test_register()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => rand(1111111111,9999999999),
            'password' => $this->faker->password,
            'address' => $this->faker->address
        ];

        $data['password_confirmation'] = $data['password'];

        $this->runPost([
            'data' => $data, 
            'route'=> 'register', 
            'status' => 201,
            'authorize' => false
        ]);
    }
    
}
