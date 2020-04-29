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

        foreach($fieldNames as $fieldName) {
            $child = $this->$fieldName;
            $childName = Str::camel($fieldName);
            if($child instanceof XMLFormattableInterface) {
                $xml->addChildElement($child->toXML());
            } else {
                $xml->addChild($childName, $child);
            }
        }
        
        return $xml; 
    }

    public function newCollection(array $models = [])
    {   
        $collection = new FormattableCollection($models);
        $collection->xmlElementName(Str::camel($this->getTable()));
        return $collection;
    }

}