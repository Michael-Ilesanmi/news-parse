<?php

namespace Tests\Feature;

use App\Http\Controllers\NewsController;
use ErrorException;
use Tests\TestCase;

class XmlTest extends TestCase
{
    public function testParseValidXml(): void
    {
        $xmlString = '<root><element>value</element></root>';
        $xmlParser = new NewsController();
        $result = $xmlParser->parseXML($xmlString);
        $expectedArray = [
            'element' => 'value'
        ];
        $this->assertEquals($expectedArray, $result);
    }

    public function testParseXMLInvalidXml()
    {
        $this->expectException(ErrorException::class);
        $xml = 'invalid_xml';
        $xmlParser = new NewsController();
        $xmlParser->parseXML($xml);
    }
}
