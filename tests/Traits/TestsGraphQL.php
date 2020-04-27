<?php

namespace Tests\Traits;

use \Illuminate\Testing\TestResponse as Response;

trait TestsGraphQL
{
    protected function callGraphQL($query) :Response
    { 
        return $this->postJson("graphql", [
            "query" => $query,
        ]);
    }

    protected function assertGraphQLFragment(Response $response, array $expected)
    {
        $this->assertSame(
            $response->getContent(), 
            json_encode(["data" => $expected])
        );
    }
}
