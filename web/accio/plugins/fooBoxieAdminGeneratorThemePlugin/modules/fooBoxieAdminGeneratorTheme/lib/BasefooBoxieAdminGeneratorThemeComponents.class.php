<?php
/**
 * fooBoxieAdminGeneratorTheme base components.
 *
 * @package    plugins
 * @subpackage fooBoxieAdminGeneratorTheme
 * @author     Ivan Tanev aka Crafty_Shadow @ webworld.bg <vankata.t@gmail.com>
 * @version    SVN: $Id: BasefooBoxieAdminGeneratorThemeComponents.class.php 25335 2009-12-14 12:49:08Z Crafty_Shadow $
 */ 
class BasefooBoxieAdminGeneratorThemeComponents extends sfComponents
{

  /**
  * The main navigation component for the fooBoxieAdminGeneratorTheme plugin
  */  
  public function executeHeader()
  {
    $this->items      = fooBoxieAdminGeneratorTheme::getItems();
    $this->categories = fooBoxieAdminGeneratorTheme::getCategories();
    $this->called_from_component = true; // BC check
        
    if (sfConfig::get('sf_error_404_module') == $this->getContext()->getModuleName() && sfConfig::get('sf_error_404_action') == $this->getContext()->getActionName())
    {
      fooBoxieAdminGeneratorTheme::setProperty('include_path', false); // we don't render the breadcrumbs when we are in a 404 error module/action
      $this->module_link = null;
      $this->action_link = null;
    }
    else
    {
      if (!fooBoxieAdminGeneratorTheme::routeExists($this->module_link = $this->getContext()->getModuleName(), $this->getContext()))
      {
        // if we cannot sniff the module link, we set it to null and later simply output is as a string in the breadcrumbs
        $this->module_link = null;
        // but before we do that, one last check - it's possible that the module name is different from the object name and that's the reason we can't sniff it
        foreach (fooBoxieAdminGeneratorTheme::getAllItems() as $name => $item) if ($name == $this->getContext()->getModuleName()) { $this->module_link = $item['url']; break; }
      }

      $this->module_link_name = fooBoxieAdminGeneratorTheme::getModuleName($this->getContext());
      
      if ($this->getContext()->getActionName() != 'index')
      {
        $this->action_link = $this->getContext()->getRouting()->getCurrentInternalUri();
        $this->action_link_name = fooBoxieAdminGeneratorTheme::getActionName($this->getContext());
      }
      else
      {
        $this->action_link = null;
      }
    }
    
  } 

}