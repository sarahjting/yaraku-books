<?php

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Interfaces\XMLFormattableInterface;
use App\Models\Traits\FormatsToXML;

use SimpleXMLElement;

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

        $xml = new SimpleXMLElement("<{$elementName} />");

        // TODO - requires refactoring
        // https://stackoverflow.com/a/4778964
        // don't know if this is the best solution but will come back to it later to have another look
        // also, doesn't belong in this class; consider making an XML handling class or extending SimpleXMLElement
        $collectionDOM = dom_import_simplexml($xml);
        foreach($this as $item) {
            $itemDOM = dom_import_simplexml($item->toXml($fields));
            $collectionDOM->appendChild($collectionDOM->ownerDocument->importNode($itemDOM, true));
        }
        
        return $xml; 
    }
}