<div class="boxin" style="margin: 15px; padding: 5px; width: 918px">
	<h2>Enlaces rápidos</h2>
	<div class="cpanel">
		<div style="float: left">
			<div class="icon">
				<a href="<?php echo url_for('pagina/new') ?>" title="Nueva página">    
					<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/documents48.png', array('alt' => 'Nueva página')); ?>
					<span>Crear página nueva</span>
				</a>
			</div>        
		</div>
		<?php if($contenidos->count() > 0): ?>
			<?php foreach($contenidos as $contenido): ?>
				<div style="float: left">
					<div class="icon">
						<a href="<?php echo url_for('contenido/new?categoria_id='.$contenido->id) ?>" title="Nuevo <?php echo $contenido->nombre ?>">    
							<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/report48.png', array('alt' => 'Nuevo '.$contenido->nombre)); ?>
							<?php $singular = substr($contenido->nombre, -1) == 's' ? substr($contenido->nombre, 0, -1) : $contenido->nombre ?>
							<?php $genero = substr($singular, -1) == 'a' ? 'Nueva ' : 'Nuevo ' ?>
							<span><?php echo $genero.$singular ?></span>
						</a>
					</div>        
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>
