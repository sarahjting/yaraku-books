<?php

namespace Tests\Traits;

trait TestsXML
{
    protected function assertXmlEquals($xml, $string) {
        $this->assertEquals(substr($xml, 0, 22), "<?xml version=\"1.0\"?>\n");
        $this->assertEquals(substr($xml, 22, -1), $string);
    }
}
