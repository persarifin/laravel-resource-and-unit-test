<?php

namespace Tests\Unit;

use Tests\TestCase;

class DanaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get()
    {
        $this->runGet([
            'route' => 'dana-user', 
            'status' => 200,
            'authorize' => true
        ]);
    }
}
