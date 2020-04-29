<?php

namespace Tests\Traits;

trait TestsXML
{
    protected function assertXMLEquals(string $expectedXML, string $actualXML) {
        $this->assertEquals($this->filterXml($actualXML), $this->filterXml($expectedXML));
    }
    protected function filterXML($xml) {
        return str_replace(["\n", "<?xml version=\"1.0\"?>"], "", $xml);
    }
}
