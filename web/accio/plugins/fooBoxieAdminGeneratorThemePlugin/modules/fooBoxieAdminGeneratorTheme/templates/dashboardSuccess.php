<?php
  use_helper('I18N');
  /** @var Array of menu items */ $items = $sf_data->getRaw('items');
  /** @var Array of categories, each containing an array of menu items and settings */ $categories = $sf_data->getRaw('categories');
?>
<?php if (count($components)): ?>
	<?php foreach ($components as $module_name => $component_datos): ?>
		<div id="box1" class="box box-<?php echo $component_datos['talla']?>"><!-- box full-width -->
			<div class="boxin">
				<div class="header">
					<h3><?php echo $component_datos['titulo']; ?></h3>
				</div>
				<div class="content clearfix" style="padding:10px">
					<?php include_component($module_name, $component_datos['nombre'])  ?>
				</div>
			</div>
		</div>
	<?php endforeach;?>
<?php endif;?>

<div id="sf_admin_container">
	<?php echo include_partial('flashes') ?>
	<div id="box1" class="box box-100">
		<div class="boxin">
			<div class="header">
				<h3>Panel de Control</h3>
			</div>
			<div class="content clearfix">
				<?php if($sf_user->hasCredential('web') && (strpos($sf_request->getScriptName(), 'backend')) != false): ?>
					<?php include_component('fooBoxieAdminGeneratorTheme', 'contenidos') ?>
				<?php endif; ?>
				<?php if (count($categories)): ?>
					<?php foreach ($categories as $name => $category): ?>
						<?php if (fooBoxieAdminGeneratorTheme::hasPermission($category, $sf_user)): ?>
							<div class="boxin" style="margin: 15px; padding: 5px;float: left; width: 430px">
								<h2><?php echo __(isset($category['name']) ? $category['name'] : $name, null, 'sf_admin_dash'); ?></h2>
								<?php include_partial('dash_list', array('items' => $category['items'])); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php elseif (!count($items)): ?>
					¡El panel de control no ha sido configurado!
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
