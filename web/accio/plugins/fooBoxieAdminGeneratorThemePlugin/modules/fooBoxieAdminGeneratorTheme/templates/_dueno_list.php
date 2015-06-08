<?php if($contenidos->count() > 0): ?>
	<?php foreach($contenidos as $contenido): ?>
		<li class="item">
			<a href="<?php echo url_for('contenido/new?categoria_id='.$contenido->id) ?>">    
				<?php echo image_tag('contenido'); ?>
				<?php $singular = substr($contenido->nombre, -1) == 's' ? substr($contenido->nombre, 0, -1) : $contenido->nombre ?>
				<?php $genero = substr($singular, -1) == 'a' ? 'Nueva ' : 'Nuevo ' ?>
				<span><?php echo $genero.$singular ?></span>
			</a>
		</li>
	<?php endforeach; ?>
<?php endif; ?>
<?php if($paginas->count() > 0): ?>
	<?php foreach($paginas as $pagina): ?>
		<li class="item">
			<?php $contenido = $pagina->getContenidoUnico() ?>
			<?php if(!$contenido): ?>
				<a href="<?php echo url_for('contenido/new?categoria_id='.$pagina->id) ?>">    
			<?php else: ?>
				<a href="<?php echo url_for('contenido/edit?id='.$contenido->id) ?>" title="Contenido en <?php echo $pagina->nombre ?>">    
			<?php endif; ?>
			<?php echo image_tag('contenido'); ?>
			<span><?php echo $pagina->nombre ?></span>
			</a>
		</li>
	<?php endforeach; ?>
<?php endif; ?>
<li class="item">
	<a href="<?php echo url_for('@contacto') ?>">
		<?php echo image_tag('contacto') ?>
		<span>Información de Contacto</span>
	</a>
</li>
<li class="item">
	<a href="<?php echo url_for('@publicidad') ?>">
		<?php echo image_tag('publicidad') ?>
		<span>Publicidad</span>
	</a>
</li>
<li class="item">
	<a href="<?php echo url_for('info/index') ?>">
		<?php echo image_tag('info_extra') ?>
		<span>Información Extra</span>
	</a>
</li>