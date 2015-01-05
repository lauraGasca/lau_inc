<?php
/**
 * fooBoxieAdminGeneratorThemeConfig class
 * 
 * This class handles configuration for the fooBoxieAdminGeneratorThemePlugin
 *
 * @package    plugins
 * @subpackage fooBoxieAdminGeneratorTheme
 * @author     Ivan Tanev aka Crafty_Shadow @ webworld.bg <vankata.t@gmail.com>
 * @version    SVN: $Id: fooBoxieAdminGeneratorThemeConfig.php 25407 2009-12-15 12:35:24Z Crafty_Shadow $
 */ 
class fooBoxieAdminGeneratorThemeConfig
{
  /**
  * After the context has been initiated, we can add the required assets
  * 
  * @param sfEvent $event
  */
  public static function listenToContextLoadFactoriesEvent(sfEvent $event)
  {
    /** @var sfContext */
    $context = $event->getSubject();

    $context->getResponse()->addStylesheet(fooBoxieAdminGeneratorTheme::getProperty('web_dir').'/css/boxie.css', 'first');
    $context->getResponse()->addJavascript(fooBoxieAdminGeneratorTheme::getProperty('web_dir').'/js/sf_admin_dash.js', 'last');
    
    //$context->getResponse()->addJavascript(sfConfig::get('sf_jquery_web_dir', '/sfJqueryReloadedPlugin') .
      //                            '/js/' . sfConfig::get('sf_jquery_core', 'jquery-1.3.2.min.js'), 'first');
  }
  
  
  /**
  * This is the right way to add stuff to the <head> tag after the page has been generated :)
  * The principle is the same as with the old sfCommonFilter and asset insertion in sf 1.0-1.2
  * 
  * @param sfEvent $event
  * @param string  $content
  * 
  * @return string
  */
  public static function listenToResponseFilterContentEvent(sfEvent $event, $content = null)
  {
    $jquery_include_tag = '<script type="text/javascript" src="'.fooBoxieAdminGeneratorTheme::getProperty('web_dir').'/js/'.fooBoxieAdminGeneratorTheme::getProperty('jquery_filename').'"></script>';
    $jquery_no_conflict_tag = '<script type="text/javascript">jQuery.noConflict();</script>';
    
    if (false !== ($pos = strpos($content, $jquery_include_tag)))
    {
      $content = substr($content, 0, $pos + strlen($jquery_include_tag)).$jquery_no_conflict_tag.substr($content, $pos + strlen($jquery_include_tag));
    }
    
    return $content;
  }

  public function initialize()
  {
  }
}