<?php

namespace App\Models\Traits;

use App\Models\Collections\FormattableCollection;
use App\Models\Interfaces\XMLFormattableInterface;

use App\Utilities\XML\XMLElement;
use SimpleXMLElement;
use Str;

trait FormatsEloquentToXML {

    public function xmlFieldNames(): array
    {
        return $this->visible;
    }

    public function xmlElementName(): string
    {
        return Str::singular($this->getTable());
    }

    public function toXML(string $elementName = null, array $fieldNames = null): SimpleXMLElement
    {
        $elementName = $elementName ?: $this->xmlElementName();
        $fieldNames = $fieldNames ?: $this->xmlFieldNames();

        $xml = new XMLElement("<{$elementName}></{$elementName}>");
        $childNodes = [];

        // TODO: refactor
        foreach($fieldNames as $fieldName) {
            $indexOfFirstPeriod = strpos($fieldName, ".");
            if($indexOfFirstPeriod !== FALSE) {

                $nestedName = substr($fieldName, 0, $indexOfFirstPeriod);
                if(isset($childNodes[$nestedName])) continue;
                $childNodes[$nestedName] = true; 

                // why does array_map take a function as first parameter but array_filter takes it as second
                $nestedFields = array_map(
                    function($el) use($nestedName) {
                        return substr($el, strlen($nestedName) + 1);
                    }, array_filter($fieldNames, function($el) use($nestedName) { 
                        return substr($el, 0, strlen($nestedName) + 1) === "{$nestedName}."; 
                    })
                );
                $xml->addChildElement($this->$nestedName->toXML(Str::camel($nestedName), $nestedFields));

            } else {

                $child = $this->$fieldName;
                $childName = Str::camel($fieldName);
                if($child instanceof XMLFormattableInterface) {
                    $xml->addChildElement($child->toXML());
                } else {
                    $xml->addChild($childName, $child);
                }

            }

        }
        
        return $xml; 
    }

}