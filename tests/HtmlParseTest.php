<?php
use Gufy\PdfToHtml\Html;
class HtmlParseTest extends PHPUnit_Framework_TestCase
{
  public function testConvertAndCatch()
  {
    $pdf = dirname(__FILE__).'/source/test.pdf';
    $html = new Html($pdf);
    $this->assertInstanceOf('PHPHtmlParser\\Dom', $html);
  }
}
