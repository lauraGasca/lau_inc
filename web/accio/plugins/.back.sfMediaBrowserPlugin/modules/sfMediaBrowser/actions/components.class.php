<?php

require_once dirname(__FILE__).'/../lib/BasesfMediaBrowserComponents.class.php';

/**
 *
 *
 * @package     sfMediaBrowser
 * @author      Vincent Agnano <vincent.agnano@particul.es>
 */
class sfMediaBrowserComponents extends BasesfMediaBrowserComponents
{
    public function executeTree()
    {
        $this->dir_root = $this->getUser()->getAttribute('root_dir');
        $this->i=1;
        $this->directorios= array();
        $this->directorios[]=array(
                    'id' => 0,
                    'nivel'=> 0,
                    'nombre' => '/',
                    'path'=> '/'
                    );
        $this->listDirectory(sfConfig::get('sf_web_dir').'/'.$this->dir_root);
        $this->ruta = $this->getContext()->getRouting()->getCurrentRouteName();
        //var_dump($this->directorios);
        $this->record= $this->directorios;
        if($this->getRequestParameter('dir'))
            $this->dir_actual = $this->getRequestParameter('dir');
        else
            $this->dir_actual = '/';
    }

    function listDirectory($path)
    {
        $handle = @opendir($path);
        //
        //echo "<br><br>";
       
        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..' || $file[0]=='.') continue;

            if ( is_dir("$path/$file")) {
                $ruta_dir = str_replace(sfConfig::get('sf_web_dir').'/'.$this->dir_root, "", "$path/$file");
                $this->directorios[]=array(
                    'id' => $this->i,
                    'nivel'=> substr_count("$path/$file", "/"),
                    'nombre' => $file,
                    'path'=> $ruta_dir
                    );
                $this->i++;
                $this->listDirectory("$path/$file");
            }
        
            
        }

        closedir($handle);
    }
}