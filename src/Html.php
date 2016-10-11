<?php

namespace Gufy\PdfToHtml;

use DOMDocument;
use DOMNode;
use DOMXPath;
use PHPHtmlParser\Dom;

class Html extends Dom
{
    protected $contents, $total_pages, $current_page, $pdf_file, $locked = false;

    public function __construct($pdf_file)
    {
        $this->getContents($pdf_file);

        return $this;
    }

    private function getContents($pdf_file)
    {
        $this->locked = true;
        $info = new Pdf($pdf_file);
        $pdf = new Base($pdf_file, [
            'singlePage' => true,
            'noFrames'   => false,
        ]);
        $pages = $info->getPages();

        $random_dir = uniqid();
        $outputDir = Config::get('pdftohtml.output', dirname(__FILE__).'/../output/'.$random_dir);
        if (!file_exists($outputDir))
            mkdir($outputDir, 0777, true);
        $pdf->setOutputDirectory($outputDir);
        $pdf->generate();
        $fileinfo = pathinfo($pdf_file);
        $base_path = $pdf->outputDir.'/'.$fileinfo['filename'];
        $contents = [];
        for ($i = 1; $i <= $pages; $i++) {
            $content = file_get_contents($base_path.'-'.$i.'.html');
            $content = str_replace("Â", "", $content);
            if ($this->inlineCss()) {
                $dom = new DOMDocument();
                $dom->loadHTML($content);
                $xpath = new DOMXPath($dom);
                foreach ($xpath->query('//comment()') as $comment) {
                    $comment->parentNode->removeChild($comment);
                }
                $body = $xpath->query('//body')->item(0);
                $content = $body instanceof DOMNode ? $dom->saveHTML($body) : 'something failed';
            }
            file_put_contents($base_path.'-'.$i.'.html', $content);
            $contents[ $i ] = file_get_contents($base_path.'-'.$i.'.html');
        }
        $this->contents = $contents;
        $this->goToPage(1);
    }

    public function goToPage($page = 1)
    {
        if ($page > count($this->contents))
            throw new \Exception("You're asking to go to page {$page} but max page of this document is ".count($this->contents));
        $this->current_page = $page;

        return $this->load($this->contents[ $page ]);
    }

    public function raw($page = 1)
    {
        return $this->contents[ $page ];
    }

    public function getTotalPages()
    {
        return count($this->contents);
    }

    public function getCurrentPage()
    {
        return $this->current_page;
    }

    public function inlineCss()
    {
        return Config::get('pdftohtml.inlineCss', true);
    }
}
