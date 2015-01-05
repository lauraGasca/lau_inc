<?php if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')): ?>
	<div class="flash">
<?php endif; ?>

<?php if ($sf_user->hasFlash('notice')): ?>
	<div class="msg msg-info">
		<p><?php echo $sf_user->getFlash('notice') ?></p>
	</div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  	<div class="msg msg-error">
  		<p><?php echo $sf_user->getFlash('error') ?></p>
  	</div>
<?php endif; ?>

<?php if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')): ?>
	</div>
<?php endif; ?>
