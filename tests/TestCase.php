<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory;
use App\repositories\BaseRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    protected $faker;

    public function setUp(): void{
        parent::setUp();
        \Artisan::call('passport:install',['-vvv' => true]);
        $this->faker = Factory::create();
        $this->withoutExceptionHandling();
    }

    public function auth()
    {
        return \App\Models\User::factory()->has(\App\Models\Dana::factory()->count(1))->create();
        
    }

    public function runPost($header = [])
    {
        if ($header['authorize'] == true) {
            $response = $this->actingAs($this->auth())->post(route($header['route']), $header['data']);
        }
        else {
            $response = $this->post(route($header['route']), $header['data']);
        }
        return $response
                // ->dd()
                ->assertStatus($header['status']);
    }

    public function runGet($header=[])
    {
        if ($header['authorize'] == true) {
            $response = $this->actingAs($this->auth())->get(route($header['route']));
        }else {
            $response = $this->get(route($header['route']));
        }
        return $response
                // ->dd()
                ->assertStatus($header['status']);
    }

    public function runUpdate($header = [])
    {
        if ($header['authorize'] == true) {
            $response = $this->actingAs($this->auth())->put(route($header['route'], $header['id']), $header['data']);
        }else {
            $response = $this->put(route($header['route'], $header['id']), $header['data']);
        }
        return $response
        ->assertStatus($header['status']);
    }

    public function runDestroy($header=[])
    {
        if ($header['authorize'] == true) {
            $response = $this->actingAs($this->auth())->delete(route($header['route'], $header['id']));
        }else {
            $response = $this->delete(route($header['route'], $header['id']));
        }
        return $response
        ->assertStatus($header['status']);
    }
}
