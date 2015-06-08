<?php

/**
 *
 *
 * @package     sfMediaBrowser
 * @author      Vincent Agnano <vincent.agnano@particul.es>
 */
class BasesfMediaBrowserComponents extends sfComponents
{
  public function executeIcon(sfWebRequest $request)
  {
    $class = sfMediaBrowserUtils::getTypeFromExtension(sfMediaBrowserUtils::getExtensionFromFile($this->file_url)) == 'image'
           ? 'sfMediaBrowserImageObject'
           : 'sfMediaBrowserFileObject'
           ;
    $this->file = new $class($this->file_url);

//    if($this->file->getThumbnail()==null){
//
//      $filename = $this->file_url;
//      $name = sfMediaBrowserStringUtils::slugify(pathinfo($filename, PATHINFO_FILENAME));
//      $ext = pathinfo($filename, PATHINFO_EXTENSION);
//      $fullname = $ext ? $name.'.'.$ext : $name;
//      $this->generateThumbnail(sfConfig::get('sf_web_dir').'/'.$filename, $fullname, sfConfig::get('sf_web_dir').sfContext::getInstance()->getUser()->getAttribute('root_dir').$this->relative_dir);
//    }


  }

  protected function generateThumbnail($source_file, $destination_name, $destination_dir)
  {
    if(!class_exists('sfImage'))
    {
      throw new sfException('sfImageTransformPlugin must be installed in order to generate thumbnails.');
    }
    $thumb = new sfImage($source_file);
    $thumb->thumbnail(sfConfig::get('app_sf_media_browser_thumbnails_max_width', 64),
                     sfConfig::get('app_sf_media_browser_thumbnails_max_height', 64));
    $destination_dir = $destination_dir.'/'.sfConfig::get('app_sf_media_browser_thumbnails_dir');
    if(!file_exists($destination_dir))
    {
      mkdir($destination_dir);
      chmod($destination_dir, 0777);
    }
    return $thumb->saveAs($destination_dir.'/'.$destination_name);
  }
  
}
