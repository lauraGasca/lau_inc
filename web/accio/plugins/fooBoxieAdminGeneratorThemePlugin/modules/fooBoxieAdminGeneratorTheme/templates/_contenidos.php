<?php if (fooBoxieAdminGeneratorTheme::hasPermission('web', $sf_user)){?>
        <?php foreach($menus as $menu): ?>

	<div class="boxin" style="margin:15px;padding:5px;float:left; width:430px">
		<h2>Contenidos "<?php echo $menu ?>"</h2>
		<?php $contenidos = $menu->getContenidos() ?>
		<div class="cpanel">
			<?php foreach($contenidos as $contenido): ?>
				<div style="float: left">
        			<div class="icon">
          				<a href="<?php echo url_for('contenido/edit?id='.$contenido->id) ?>" title="<?php echo $contenido ?>">    
            				<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/edit48.png', array('alt' => $contenido)) ?>
            				<span><?php echo 'Editar "'.$contenido.'"' ?></span>
          				</a>
        			</div>        
      			</div>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
	</div>
<?php endforeach;?>
<?php }?>
<div class="boxin" style="margin:15px;padding:5px;float:left; width:430px">
    <h2>Contenidos "Cómo Aplicar"</h2>
    <div class="cpanel">
        <div style="float: left">
              <div class="icon">
                  <a href="<?php echo url_for('contenido/edit?id=20') ?>" title="Cómo Aplicar">    
                    <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/edit48.png', array('alt' => 'Cómo Aplicar')) ?>
                    <span><?php echo 'Editar "Cómo Aplicar"' ?></span>
                  </a>
              </div>        
            </div>
      <div class="clear"></div>
    </div>
  </div>
<div class="clear"></div>
<div class="boxin" style="margin:15px;padding:5px;float:left; width:430px">
	<h2>Otros recursos</h2>
	<div class="cpanel">
    <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('slider/index') ?>" title="Slider">    
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/semi_success48.png', array('alt' => 'Slider')) ?>
                <span>Slider</span>
              </a>
          </div>
        </div>
    <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('contenido/index') ?>" title="Gestión Global de Contenidos">    
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/glossary48.png', array('alt' => 'Gestión Global de Contenidos')) ?>
                <span>Gestión Global de Contenidos</span>
              </a>
          </div>
        </div>
    <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('paginacion/config') ?>" title="Paginación de Secciones">
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/configure48.png', array('alt' => 'Paginación')) ?>
                <span>Paginación de Secciones</span>
              </a>
          </div>
        </div>
    <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('aviso_privacidad/config') ?>" title="Aviso de Privacidad">    
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/info-48.png', array('alt' => 'Aviso de Privacidad')) ?>
                <span>Aviso de Privacidad</span>
              </a>
          </div>
        </div>
    <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('terminos/config') ?>" title="Términos y Condiciones">    
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/info-48.png', array('alt' => 'Términos')) ?>
                <span>Términos y Condiciones</span>
              </a>
          </div>
        </div>
		<div style="float: left">
			<div class="icon">
          		<a href="<?php echo url_for('@contacto') ?>" title="Formulario de Contacto">    
            		<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/contact48.png', array('alt' => 'Contacto')) ?>
            		<span>Formulario de Contacto</span>
          		</a>
        	</div>
      	</div>-->
      	<div style="float: left">
			<div class="icon">
          		<a href="<?php echo url_for('logo/index') ?>" title="Logos de Depedencias">    
            		<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/organization48.png', array('alt' => 'Logos')) ?>
            		<span>Logos de Depedencias</span>
          		</a>
        	</div>
      	</div>
      	<div style="float: left">
			<div class="icon">
          		<a href="<?php echo url_for('columna/edit?id='.$columna_emprendedores->id) ?>" title="Enlace Emprendedores">    
            		<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/layout48.png', array('alt' => 'Emprendedores')) ?>
            		<span>Enlace a "Emprendedores Incubamás"</span>
          		</a>
        	</div>
      	</div>
      	<div style="float: left">
			<div class="icon">
          		<a href="<?php echo url_for('columna/edit?id='.$columna_voluntarios->id) ?>" title="Enlace Voluntarios">    
            		<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/layout48.png', array('alt' => 'Voluntarios')) ?>
            		<span>Enlace a "Voluntarios"</span>
          		</a>
        	</div>
      	</div>
      	<div style="float: left">
			<div class="icon">
          		<a href="<?php echo url_for('columna/edit?id='.$columna_ayuda->id) ?>" title="Enlace Ayuda">    
            		<?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/layout48.png', array('alt' => 'Ayuda')) ?>
            		<span>Enlace a "Ayuda a Sumar"</span>
          		</a>
        	</div>
      	</div>
        <div style="float: left">
      <div class="icon">
              <a href="<?php echo url_for('faq/index') ?>" title="Preguntas Frecuentes">    
                <?php echo image_tag('../fooBoxieAdminGeneratorThemePlugin/images/icons/info-48.png', array('alt' => 'Preguntas Frecuentes')) ?>
                <span>Preguntas Frecuentes</span>
              </a>
          </div>
        </div>
        <div class="clear"></div>
	</div>
</div>
