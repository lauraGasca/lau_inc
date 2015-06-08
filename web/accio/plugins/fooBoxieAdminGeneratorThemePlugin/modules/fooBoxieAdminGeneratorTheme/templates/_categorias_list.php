<?php foreach ($categorias as $item): ?>
	<li class="item">
		<a href="<?php echo url_for('@contenido?categoria_id='.$item->id) ?>" title="<?php echo $item->nombre; ?>">
			<?php if(fooBoxieAdminGeneratorTheme::getProperty('resize_mode') == 'thumbnail'): ?>
				<?php echo image_tag('contenido') ?>
			<?php endif; ?>
			<span><?php echo $item->nombre; ?></span>
		</a>
	</li>
<?php endforeach; ?>