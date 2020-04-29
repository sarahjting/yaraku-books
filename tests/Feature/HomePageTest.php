<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_can_see_page()
    {
        $response = $this->get("/");
        $response->assertStatus(200);
    }
}
