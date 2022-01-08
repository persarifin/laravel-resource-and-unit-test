<?php

namespace Tests\Unit;

use Tests\TestCase;

class MutationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get()
    {
        $this->runGet([
            'route' => 'get-mutation',
            'status' => 200,
            'authorize' => true
        ]);
    }

    public function test_transfer()
    {
        $data = [
            'amount' => $this->faker->numberBetween(10000, 20000),
            'to_phone' => \App\Models\User::factory()->has(\App\Models\Dana::factory()->count(1))->create()->phone,
        ];
        $this->runPost([
            'data' => $data,
            'route' => 'transfer',
            'status' => 200,
            'authorize' => true
        ]);
    }
}
