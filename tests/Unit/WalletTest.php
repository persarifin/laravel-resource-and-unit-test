<?php

namespace Tests\Unit;

use Tests\TestCase;

class WalletTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get()
    {
        $this->runGet([
            'route' => 'wallets.index',
            'status' => 200,
            'authorize' => true
        ]);
    }

    public function test_post()
    {
        $data =[
            'wallet_name' => $this->faker->name
        ];

        $this->runPost([
            'data' => $data,
            'route' => 'wallets.store',
            'status' => 200,
            'authorize' => true
        ]);
    }

    public function test_update()
    {
        $newData = \App\Models\Wallet::factory()->create();
        $data =[
            'wallet_name' => $this->faker->name
        ];

        $this->runUpdate([
            'data' => $data,
            'id' => $newData->id,
            'route' => 'wallets.update',
            'status' => 200,
            'authorize' => true
        ]);
    }
    public function test_destroy()
    {
        $newData = \App\Models\Wallet::factory()->create();

        $this->runDestroy([
            'id' => $newData->id,
            'route' => 'wallets.destroy',
            'status' => 200,
            'authorize' => true
        ]);
    }
}
