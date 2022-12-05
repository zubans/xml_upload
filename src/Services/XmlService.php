<?php

namespace App\Services;

class XmlService
{
    public function XmlToArray($xmlstring): array
    {
        $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
        if ($xml) {
            $json = json_encode($xml);
            return json_decode($json,TRUE);
        }
        return false;
    }

    public function readXML()
    {

    }
}