<?php
/**
* We need to make sure this plugin is backward compatible. 
* The in the original, this template was invoked by "include_partial",
* which means that now it won't work. Therefore, we set a variable in the 
* component code, and if it is not present - we call the component
*/

if (!isset($called_from_component)):
  include_component('fooBoxieAdminGeneratorTheme', 'header');
else:
?>

<?php 
  use_helper('I18N');
  /** @var Array of menu items */ $items = $sf_data->getRaw('items');
  /** @var Array of categories, each containing an array of menu items and settings */ $categories = $sf_data->getRaw('categories');
  /** @var string|null Link to the module (for breadcrumbs) */ $module_link = $sf_data->getRaw('module_link');
  /** @var string|null Link to the action (for breadcrumbs) */ $action_link = $sf_data->getRaw('action_link');
?> 

<?php if ($sf_user->isAuthenticated()): ?>
<div id="header">
    <div class="inner-container clearfix">
        <h1 id="logo">
            <a href="http://<?php echo $sf_request->getHost() ?>/" class="home">
            <?php echo image_tag(fooBoxieAdminGeneratorTheme::getProperty('web_dir').'/images/header_text', array('alt' => 'Home')); ?>
            </a>            
        </h1>
        <div id="userbox">
             <?php if (fooBoxieAdminGeneratorTheme::getProperty('logout') && $sf_user->isAuthenticated()): ?>
            <div class="inner">
                <strong><?php echo $sf_user; ?></strong>
                <ul class="clearfix">
                    <?php if(!$sf_user->hasCredential('emprendedor')): ?>
                        <li><a href="<?php echo url_for('@usuario_edit?id='.$sf_user->getGuardUser()->id)?>">Perfil</a></li>
                    <?php endif; ?>
                    <?php if($sf_user->hasCredential('web') && (strpos($sf_request->getScriptName(), 'panel')) != false): ?>
                        <li><a href="http://<?php echo $sf_request->getHost() ?>/backend.php/">Ir a Backend</a></li>
                    <?php endif;?>
                    <?php if(($sf_user->hasCredential('director') || $sf_user->hasCredential('asesor')) && (strpos($sf_request->getScriptName(), 'backend')) != false): ?>
                       <!-- <li><a href="http://<php echo $sf_request->getHost() ?>/panel.php/">Ir a Panel</a></li> -->
                    <?php endif;?>
                </ul>
            </div>
            <a id="logout" href="<?php echo url_for(fooBoxieAdminGeneratorTheme::getProperty('logout_route', '@sf_guard_signout '));?>">
                <?php echo __('Logout', null, 'sf_admin_dash'); ?>
                <span class="ir"></span>
            </a>
            <?php endif; ?>
        </div>
        <?php if(!$sf_user->hasCredential('emprendedor') && fooBoxieAdminGeneratorTheme::getProperty('include_path')): ?>
    <div id='sf_admin_path'>
      <strong>Estas en: </strong><a href='<?php echo url_for('homepage'); ?>'>Inicio </a>
      <?php if ($sf_context->getModuleName() != 'fooBoxieAdminGeneratorTheme' && $sf_context->getActionName() != 'dashboard'): ?>
         <?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/css/boxie/img/bread-sep.gif');?>
         <?php echo null !== $module_link ? link_to($module_link_name, $module_link) : $module_link_name; ?>
        <?php if (null != $action_link): ?>
            <?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/css/boxie/img/bread-sep.gif');?>
            <?php echo link_to(__(ucfirst($action_link_name), null, 'sf_admin'), $action_link); ?>
        <?php endif ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
        <!-- #userbox -->
    </div><!-- .inner-container -->
</div><!-- #header -->
<?php if(!$sf_user->hasCredential('emprendedor')): ?>
<div id="nav">
    <div class="inner-container clearfix">
        <div id="sf_admin_menu">
            <?php include_partial('fooBoxieAdminGeneratorTheme/menu', array('items' => $items, 'categories' => $categories)); ?>
        </div>
    </div><!-- .inner-container -->
</div><!-- #nav -->
<?php endif; ?>
<?php endif; // BC check if ?>

<div id="container">
    <div class="inner-container">
 
<?php endif; ?>
