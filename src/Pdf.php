<?php namespace Gufy\PdfToHtml;

class Pdf
{
  protected $file, $info;
  protected $info_bin = '/usr/bin/pdfinfo';
  public function __construct($file, $options=array())
  {
    $this->file = $file;
    $class = $this;
    array_walk($options, function($item, $key) use($class){
      $class->$key = $item;
    });
    $this->info($file);
    return $this;
  }
  public function getInfo()
  {
    return $this->info;
  }
  protected function info()
  {
    // echo $this->info_bin.' '.$this->file;
    $content = shell_exec($this->info_bin.' '.$this->file);
    $options = explode("\n", $content);
    $info = array();
    foreach($options as &$item)
    {
      if(!empty($item))
      {
        list($key, $value) = explode(":", $item);
        $info[str_replace(array(" "),array("_"),strtolower($key))] = trim($value);
      }
    }
    // print_r($info);
    $this->info = $info;
    return $this;
    // return $content;
  }
  public function html()
  {
    return new Html($this->file);
  }
  public function getPages()
  {
    return $this->info['pages'];
  }
}
