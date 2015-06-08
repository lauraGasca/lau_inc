<?php
/**
 * fooBoxieAdminGeneratorTheme base actions.
 *
 * @package    plugins
 * @subpackage fooBoxieAdminGeneratorTheme
 * @author     Ivan Tanev aka Crafty_Shadow @ webworld.bg <vankata.t@gmail.com>
 * @version    SVN: $Id: BasefooBoxieAdminGeneratorThemeActions.class.php 25203 2009-12-10 16:50:26Z Crafty_Shadow $
 */ 
class BasefooBoxieAdminGeneratorThemeActions extends sfActions
{
 
 /**
  * Executes the index action, which shows a list of all available modules
  *
  */
  public function executeDashboard()
  {    
    $this->items = fooBoxieAdminGeneratorTheme::getItems();

    $this->categories = fooBoxieAdminGeneratorTheme::getCategories();

    $this->components = fooBoxieAdminGeneratorTheme::getComponents();
  } 
  
}