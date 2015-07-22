<?php
use Gufy\PdfToHtml\Pdf;

class PdfInfoTest extends PHPUnit_Framework_TestCase
{
  public function testGetOptions()
  {
    $file = dirname(__FILE__).'/source/test.pdf';
    $pdf = new Pdf($file);
    // print_r($pdf->getInfo());
    $this->assertArrayHasKey('pages', $pdf->getInfo());
  }
  public function testAbstract()
  {
    $file = dirname(__FILE__).'/source/test.pdf';
    $pdf = new Pdf($file);
    $html = $pdf->html();
    // echo count($html->find('body'));
    // print_r($html);
    $this->assertArrayHasKey('pages', $pdf->getInfo());
  }
}
