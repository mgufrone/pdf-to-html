<?php namespace Gufy\PdfToHtml;

class Pdf
{
  protected $file, $info;
  // protected $info_bin = '/usr/bin/pdfinfo';
  public function __construct($file, $options=array())
  {
    $this->file = $file;
    $class = $this;
    array_walk($options, function($item, $key) use($class){
      $class->$key = $item;
    });
    return $this;
  }
  public function getInfo()
  {
    if($this->info == null)
    $this->info($this->file);
    return $this->info;
  }
  protected function info()
  {
    $content = shell_exec($this->bin().' '.$this->file);
    // print_r($info);
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
    if($this->info == null)
    $this->info($this->file);
    return new Html($this->file);
  }
  public function getPages()
  {
    if($this->info == null)
    $this->info($this->file);
    return $this->info['pages'];
  }
  public function bin()
  {
    return Config::get('pdfinfo.bin', '/usr/bin/pdfinfo');
  }
}
