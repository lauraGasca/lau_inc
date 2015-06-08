<div class="boxin" style="margin: 15px; padding: 5px; width: 430px; float:left;">
	<h2>Edición de Contenidos</h2>
	<div class="cpanel">
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
		<?php if($paginas->count() > 0): ?>
			<?php foreach($paginas as $pagina): ?>
				<div style="float: left">
					<div class="icon">
						<?php $contenido = $pagina->getContenidoUnico() ?>
						<?php if(!$contenido): ?>
							<a href="<?php echo url_for('contenido/new?categoria_id='.$pagina->id) ?>" title="Contenido en <?php echo $pagina->nombre ?>">    
						<?php else: ?>
							<a href="<?php echo url_for('contenido/edit?id='.$contenido->id) ?>" title="Contenido en <?php echo $pagina->nombre ?>">    
						<?php endif; ?>
							<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/report48.png', array('alt' => 'Contenido en '.$pagina->nombre)); ?>
							<span><?php echo $pagina->nombre ?></span>
						</a>
					</div>        
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<div style="float: left">
			<div class="icon">
				<a href="<?php echo url_for('@contacto') ?>" title="Contacto">    
					<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/contact48.png', array('alt' => 'Contacto')); ?>
					<span>Información de Contacto</span>
				</a>
			</div>        
		</div>
		<div style="float: left">
			<div class="icon">
				<a href="<?php echo url_for('publicidad/index') ?>" title="Publicidad">    
					<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/camera48.png', array('alt' => 'Publicidad')); ?>
					<span>Publicidad</span>
				</a>
			</div>        
		</div>
		<div style="float: left">
			<div class="icon">
				<a href="<?php echo url_for('info/index') ?>" title="Información Extra">    
					<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/glossary48.png', array('alt' => 'Información Extra')); ?>
					<span>Información Extra</span>
				</a>
			</div>        
		</div>
		<div class="clear"></div>
	</div>
</div>
