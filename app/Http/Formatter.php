<?php

namespace App\Http;

use Illuminate\Http\Response;
use SimpleXMLElement;

class Formatter
{
    public static function format($data, $format = "json"): Response
    {
        if ($format === "xml") {
            return self::toXml($data);
        }
        return response()->json($data);
    }

    private static function toXml($data): Response
    {
        $xml = new SimpleXMLElement("<response/>");

        // Recursive conversion of the array to XML
        array_walk_recursive($data, function($value, $key) use ($xml) {
            $xml->addChild($key, htmlspecialchars($value));
        });

        // Return the XML response with proper headers
        return response($xml->asXML(), 200)
            ->header('Content-Type', 'application/xml');
    }
}
