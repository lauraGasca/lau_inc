<div class="boxin" style="margin: 15px; padding: 5px;float: left; width: 430px">
	<h2>Contenidos</h2>
	<div class="cpanel">
		<?php foreach($contenidos as $contenido): ?>
			<div style="float: left">
				<div class="icon">
					<a href="<?php echo url_for('contenido/index?categoria_id='.$contenido->id) ?>" title="<?php echo $contenido->nombre ?>">    
						<?php echo image_tag('/fooBoxieAdminGeneratorThemePlugin/images/icons/report48.png', array('alt' => $contenido->nombre)); ?>
						<span>Ver <?php echo $contenido->nombre ?></span>
					</a>
				</div>        
			</div>
		<?php endforeach; ?>
		<div class="clear"></div>
	</div>
</div>
