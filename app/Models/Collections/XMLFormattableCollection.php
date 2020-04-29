<?php

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Interfaces\XMLFormattableInterface;

use SimpleXMLElement;
use App\Utilities\XML\XMLElement;

class XMLFormattableCollection extends Collection implements XMLFormattableInterface
{
    var $xmlElementName;

    public function xmlElementName(?string $elementName = null): string
    {
        if($elementName !== null) {
            $this->xmlElementName = $elementName;
        }
        return $this->xmlElementName;
    }

    public function toXML(string $elementName = null, array $fieldNames = null): SimpleXMLElement
    {
        $elementName = $elementName ?: $this->xmlElementName();

        $xml = new XMLElement("<{$elementName} />");
        foreach($this as $item) $xml->addChildElement($item->toXML(null, $fieldNames));
        
        return $xml; 
    }
}