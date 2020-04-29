<?php

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Interfaces\XMLFormattableInterface;
use App\Models\Traits\FormatsToXML;

use SimpleXMLElement;
use App\Utilities\XML\XMLElement;

class FormattableCollection extends Collection implements XMLFormattableInterface
{
    var $xmlElementName;

    public function xmlElementName(?string $elementName = null): string
    {
        if($elementName !== null) {
            $this->xmlElementName = $elementName;
        }
        return $this->xmlElementName;
    }

    public function toXML(array $fields = []): SimpleXMLElement
    {
        $elementName = $this->xmlElementName();

        $xml = new XMLElement("<{$elementName} />");
        foreach($this as $item) $xml->addChildElement($item->toXML($fields));
        
        return $xml; 
    }
}