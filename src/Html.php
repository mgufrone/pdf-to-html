<?php namespace Gufy\PdfToHtml;
// use Gufy\PdfToHtml\B;
use PHPHtmlParser\Dom;
class Html extends Dom
{
  protected $contents, $total_pages, $current_page;
  public function __construct($pdf_file)
  {
    $this->getContents($pdf_file);
    return $this;
  }
  private function getContents($pdf_file)
  {
    // echo $file;
    $info = new Pdf($pdf_file);
    $pdf = new Base($pdf_file, array(
      'singlePage'=>true,
      'noFrames'=>false,
    ));
    $pages = $info->getPages();
    // print_r($pages);
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
    $this->current_page = $page;
    return $this->load($this->contents[$page]);
  }
  public function getTotalPages()
  {
    return count($this->contents);
  }
  public function getCurrentPage()
  {
    return $this->current_page;
  }
}
