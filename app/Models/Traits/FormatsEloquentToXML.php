<?php

namespace App\Models\Traits;

use App\Models\Collections\XMLFormattableCollection;
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

        $fieldNameArray = $this->xmlFieldNamesToArray($fieldNames);
        foreach($fieldNameArray as $fieldName => $fieldChildren) {
            $xml->addChildElement($this->fieldToXML($fieldName, $fieldChildren));
        }
        
        return $xml; 
    }

    public function xmlFieldNamesToArray(array $fieldNames): array
    {
        // this only needs to go one layer deep; further handling is passed off the child node
        $array = [];
        foreach($fieldNames as $fieldName) {

            $splitName = explode(".", $fieldName, 2);
            if(count($splitName) === 2) {
                list($prefix, $suffix) = $splitName;
                $array[$prefix] = $array[$prefix] ?? [];
                $array[$prefix][] = $suffix;
            } else {
                $array[$splitName[0]] = [];
            }

        }
        return $array;

    }

    public function fieldToXML(string $fieldName, array $fieldChildren): SimpleXMLElement {
        $childNode = null;
        $childValue = $this->$fieldName;
        $childName = Str::camel($fieldName);

        if($childValue instanceof \Illuminate\Database\Eloquent\Collection) {
            $childValue = new XMLFormattableCollection($childValue);
        }
        
        if($childValue instanceof XMLFormattableInterface) {
            return $childValue->toXML($childName, $fieldChildren);
        } else {
            return new XMLElement("<{$childName}>{$childValue}</{$childName}>");
        }
    }

}