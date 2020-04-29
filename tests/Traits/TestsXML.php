<?php

namespace Tests\Traits;

trait TestsXML
{
    protected function assertXmlEquals($xml, $string) {
        $this->assertEquals($this->filterXml($xml), $this->filterXml($string));
    }
    protected function filterXml($xml) {
        return str_replace(["\n", "<?xml version=\"1.0\"?>"], "", $xml);
    }
}
