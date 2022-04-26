<?php

namespace Tests\Unit;

use Tests\TestCase;

class getIndex extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertSuccessful();
    }

}
