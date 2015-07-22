<?php namespace Gufy\PdfToHtml;
// use Gufy\PdfToHtml\B;
use PHPHtmlParser\Dom;
class Html extends Dom
{
  protected $contents, $total_pages;
  public function __construct($pdf_file)
  {
    // parent::__construct();
    $this->getContents($pdf_file);
    return $this;
  }
  private function getContents($pdf_file)
  {
    $info = new Pdf($pdf_file);
    $pdf = new Base($pdf_file, array(
      'singlePage'=>false,
    ));
    $pages = $info->getPages();
    $random_dir = uniqid();
    $outputDir = dirname(__FILE__).'/../output/'.$random_dir;
    if(!file_exists($outputDir))
    mkdir($outputDir, 0777, true);
    $pdf->setOutputDirectory($outputDir);
    $pdf->generate();
    $fileinfo = pathinfo($pdf_file);
    $base_path = $pdf->outputDir.'/'.$fileinfo['filename'];
    for($i=1;$i<=$pages;$i++)
    $contents[$i] = file_get_contents($base_path.'-'.$i.'.html');
    $this->contents = $contents;
    $this->goToPage(1);
  }
  public function goToPage($page=1)
  {
    if($page>count($this->contents))
    throw new \Exception("You're asking to go to page {$page} but max page of this document is ".count($this->contents));
    return $this->load($this->contents[$page]);
  }
  public function getTotalPages()
  {
    return $this->total_pages;
  }
}
