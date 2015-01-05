<?php use_helper('I18N'); ?>
<div class="box box-50 altbox">
	<div class="boxin">
		<div class="header">
			<h3>Iniciar sesión</h3>
			<ul class="tabs">
				<li><a href="#" class="active">identificación</a></li>
				<li><a href="#">olvidé mi contraseña</a></li>
			</ul>
		</div>
		<div class="panes">
			<div class="inner-form">
				<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
					<div class="msg msg-info">
						<?php if(!$sf_user->getFlash('notice') && !$sf_user->getFlash('error')): ?>
							<p>Bienvenido a <?php echo sfConfig::get('app_nombre_sitio') ?></p>
						<?php endif; ?>
						<?php if($sf_user->getFlash('notice')): ?>
							<p><?php echo $sf_user->getFlash('notice') ?></p>
						<?php endif; ?>
						<?php if($sf_user->getFlash('error')): ?>
							<p><?php echo $sf_user->getFlash('error') ?></p>
						<?php endif; ?>
					</div>
    				<?php echo $form->renderGlobalErrors(); ?>
    				<?php echo $form->renderHiddenFields() ?>
					<table cellspacing="0">
						<tr>
							<th><?php echo $form['username']->renderLabel(__('Username', array(), 'sf_admin_dash')); ?>:</th>
							<td>
								<?php echo $form['username']->renderError(); ?>
                                <?php echo $form['username']->render(array('class' => 'txt')); ?>
    						</td>
						</tr>
						<tr>
							<th><?php echo $form['password']->renderLabel(__('Password', array(), 'sf_admin_dash')); ?>:</th>
							<td>
                        		<?php echo $form['password']->renderError(); ?>
                        		<?php echo $form['password']->render(array('class' => 'txt pwd')); ?>
                        	</td>
						</tr>
						<tr>
							<th>
								<a href="http://<?php echo $sf_request->getHost() ?>/" class="button altbutton" style="white-space:nowrap">Ir a sitio</a>
							</th>
							<td class="tr proceed">
								<input type="submit" class="button" value="Acceso" style="margin-right: 22px" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="inner-form">
				<form action="<?php echo url_for('@sf_guard_password') ?>" method="post">
					<div class="msg msg-info">
						<?php if(!$sf_user->getFlash('notice') && !$sf_user->getFlash('error')): ?>
							<p>Una nueva contraseña sera enviada a tu email</p>
						<?php endif; ?>
						<?php if($sf_user->getFlash('notice')): ?>
							<p><?php echo $sf_user->getFlash('notice') ?></p>
						<?php endif; ?>
						<?php if($sf_user->getFlash('error')): ?>
							<p><?php echo $sf_user->getFlash('error') ?></p>
						<?php endif; ?>
					</div>
					<?php echo $recupera_form->renderGlobalErrors(); ?>
    				<?php echo $recupera_form->renderHiddenFields() ?>
					<table cellspacing="0">
						<tr>
							<th><?php echo $recupera_form['email']->renderLabel('Email'); ?>:</th>
							<td>
								<?php echo $recupera_form['email']->renderError(); ?>
                                <?php echo $recupera_form['email']->render(array('class' => 'txt')); ?>
    						</td>
						</tr>
						<tr>
							<th></th>
							<td class="tr proceed">
								<input type="submit" class="button" value="¡Recuperar!" style="margin-right: 22px" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
	$("ul.tabs").tabs("div.panes > div");
});
</script>

