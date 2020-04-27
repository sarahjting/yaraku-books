<?php

namespace Tests\Traits;

use \Illuminate\Testing\TestResponse as Response;

trait TestsGraphQL
{
    protected function callGraphQL($query, array $variables = []) :Response
    { 
        return $this->postJson("graphql", [
            "query" => $query,
            "variables" => $variables, 
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
