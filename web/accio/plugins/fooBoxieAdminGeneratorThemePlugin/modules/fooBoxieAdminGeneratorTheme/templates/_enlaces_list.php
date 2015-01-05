<li class="item">
	<a href="<?php echo url_for('pagina/new') ?>">
		<?php echo image_tag('pagina') ?>
		<span>Crear página nueva</span>
	</a>
</li>
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