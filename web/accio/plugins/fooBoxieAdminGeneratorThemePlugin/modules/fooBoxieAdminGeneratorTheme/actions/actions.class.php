<?php
require_once(dirname(__FILE__).'/../lib/BasefooBoxieAdminGeneratorThemeActions.class.php');

/**
 * fooBoxieAdminGeneratorTheme actions.
 *
 * @package    plugins
 * @subpackage fooBoxieAdminGeneratorTheme
 * @author     kevin
 * @version    SVN: $Id: actions.class.php 25203 2009-12-10 16:50:26Z Crafty_Shadow $
 */ 
class fooBoxieAdminGeneratorThemeActions extends BasefooBoxieAdminGeneratorThemeActions
{
	public function executeDashboard()
	{
		if($this->getUser()->hasCredential('emprendedor'))
		{
			$emprendedor = $this->getUser()->getGuardUser()->Emprendedor;
			$this->redirect('emprendedor/perfil?id='.$emprendedor->id);
		} else {
			parent::executeDashboard();
		}
	}
}