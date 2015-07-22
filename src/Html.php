<?php namespace Gufy\PdfToHtml\Parser;
use Gufy\PdfToHtml;
use PHPHtmlParser\Dom;
class Html extends Dom
{
  public function __construct($pdf_file)
  {
    // parent::__construct();
    $pdf = new PdfToHtml($pdf_file, array(
      'singlePage'=>true,
    ));
    // $dom = new Dom;
    $this->load($pdf->html());
    return $this;
  }
}
