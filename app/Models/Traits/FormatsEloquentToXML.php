<?php

namespace App\Models\Traits;

use App\Models\Collections\FormattableCollection;

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

    public function toXML(array $fields = null): SimpleXMLElement
    {
        $elementName = $this->xmlElementName();
        $fieldNames = $fields ?: $this->xmlFieldNames();

        $xml = new SimpleXMLElement("<{$elementName}></{$elementName}>");

        foreach($fieldNames as $fieldName) {
            $xml->addChild(Str::camel($fieldName), $this->$fieldName);
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