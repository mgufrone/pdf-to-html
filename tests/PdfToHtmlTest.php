<?php

use Gufy\PdfToHtml\Base as PdfToHtml,
 Gufy\PdfToHtml\Config;

class PdfToHtmlTest extends \PHPUnit_Framework_TestCase
{
	public $bin;
	public function setUp()
	{
		parent::setUp();
		$this->bin = new PdfToHtml;

		    Config::set('pdfinfo.bin', '/usr/bin/pdfinfo');
		    Config::set('pdftohtml.bin', '/usr/bin/pdftohtml');
	}
	public function testOpen()
	{
		$file = __DIR__.'/source/test.pdf';
		$this->assertTrue(file_exists($file));
		$this->bin->open($file);
	}
	public function testOpenAndGenerate()
	{

		$file = __DIR__.'/source/test.pdf';
		$this->assertTrue(file_exists($file));
		$this->bin->open($file);
		$this->bin->setOutputDirectory(__DIR__.'/results');

		$this->bin->generate();
		$this->assertTrue(count(scandir(__DIR__.'/results'))>=3);

		$this->bin->clearOutputDirectory();
	}
	public function testGenerateSinglePage()
	{
		$file = __DIR__.'/source/test.pdf';
		$this->assertTrue(file_exists($file));
		$this->bin->open($file);
		$this->bin->setOutputDirectory(__DIR__.'/results');

		$this->bin->setOptions("singlePage",true);
		$this->bin->generate();
		$this->assertTrue(count(scandir(__DIR__.'/results'))>=3);

		$this->bin->clearOutputDirectory();
	}
	public function getRawHtml(){

	}
}
