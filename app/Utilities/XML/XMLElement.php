<?php

namespace App\Utilities\XML;

use SimpleXMLElement;

class XMLElement extends SimpleXMLElement {

    public function addChildElement(SimpleXMLElement $element) {
        $parentDOM = dom_import_simplexml($this);
        $childDOM = dom_import_simplexml($element);
        $parentDOM->appendChild($parentDOM->ownerDocument->importNode($childDOM, true));
    }
}