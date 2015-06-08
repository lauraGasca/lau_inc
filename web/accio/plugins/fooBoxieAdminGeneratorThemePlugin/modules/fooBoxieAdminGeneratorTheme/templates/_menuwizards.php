<?php if($sf_user->hasCredential('admin')): ?>
	<li class="node">
		<a href="#">Enlaces rápidos</a>
		<ul>
			<?php include_partial('fooBoxieAdminGeneratorTheme/enlaces_list', array('contenidos' => $contenidos)) ?>
		</ul>
	</li>
<?php endif; ?>