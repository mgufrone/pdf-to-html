<?php
use Gufy\PdfToHtml\Pdf,
 Gufy\PdfToHtml\Config;

class PdfInfoTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){
    parent::setUp();

    Config::set('pdfinfo.bin', '/usr/bin/pdfinfo');
    Config::set('pdftohtml.bin', '/usr/bin/pdftohtml');
  }
  public function testGetOptions()
  {
    $file = dirname(__FILE__).'/source/test.pdf';
    $pdf = new Pdf($file);
    $this->assertArrayHasKey('pages', $pdf->getInfo());
  }
  public function testAbstract()
  {
    $file = dirname(__FILE__).'/source/test.pdf';
    $pdf = new Pdf($file);
    $html = $pdf->getDom();
    $this->assertArrayHasKey('pages', $pdf->getInfo());
  }
  public function testChangePage()
  {
    $file = dirname(__FILE__).'/source/test.pdf';
    $pdf = new Pdf($file);
    $html = $pdf->getDom();

    $this->assertEquals(1, $html->getCurrentPage());
    $html->goToPage(1);
    $this->assertEquals(1, $html->getCurrentPage());
    $this->assertEquals(1, $html->getTotalPages());
    $this->assertArrayHasKey('pages', $pdf->getInfo());
  }
}
