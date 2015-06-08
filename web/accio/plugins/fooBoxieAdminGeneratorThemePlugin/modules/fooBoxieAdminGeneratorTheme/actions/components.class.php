<?php
require_once(dirname(__FILE__).'/../lib/BasefooBoxieAdminGeneratorThemeComponents.class.php');

/**
 * fooBoxieAdminGeneratorTheme components.
 *
 * @package    plugins
 * @subpackage fooBoxieAdminGeneratorTheme
 * @author     kevin
 * @version    SVN: $Id: components.class.php 25203 2009-12-10 16:50:26Z Crafty_Shadow $
 */ 
class fooBoxieAdminGeneratorThemeComponents extends BasefooBoxieAdminGeneratorThemeComponents
{
	public function executeContenidos()
	{
		$this->menus = Doctrine_Core::getTable('Menu')->findByEsContenido(1);

		$this->columna_emprendedores = Doctrine_Core::getTable('Columna')->findOneByClave('emprendedores');
		$this->columna_voluntarios = Doctrine_Core::getTable('Columna')->findOneByClave('voluntarios');
		$this->columna_ayuda = Doctrine_Core::getTable('Columna')->findOneByClave('ayuda');
	}
}