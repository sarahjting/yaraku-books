<?php

namespace App\Models\Interfaces;

use SimpleXMLElement;

interface XMLFormattableInterface {
    public function xmlElementName(): string;
    public function toXML(array $fields = []): SimpleXMLElement;
}