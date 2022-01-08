<?php

namespace Tests\Unit;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get()
    {
        $this->runGet([
            'route'=> 'transactions', 
            'status' => 200,
            'authorize' => true
        ]);
    }

    public function test_topUp()
    {
        $data = [
            'amount' => $this->faker->numberBetween(10000,20000),
            'wallet_id' => \App\Models\Wallet::factory()->create()->id
        ];
        $this->runPost([
            'data' => $data,
            'route'=> 'top-up', 
            'status' => 200,
            'authorize' => true
        ]);
    }

    public function test_withDraw()
    {
        $data = [
            'amount' => $this->faker->numberBetween(10000,20000),
            'wallet_id' => \App\Models\Wallet::factory()->create()->id
        ];
        $this->runPost([
            'data' => $data,
            'route'=> 'with-draw', 
            'status' => 200,
            'authorize' => true
        ]);
    }
}
