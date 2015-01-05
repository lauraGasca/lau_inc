[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]


<div id="sf_admin_container">

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>

  [?php if(sfContext::getInstance()->getController()->componentExists('<?php echo $this->getModuleName() ?>', 'default')):?]
     [?php include_component('<?php echo $this->getModuleName() ?>','default') ?]
  [?php endif;?]

    <div id="box1" class="box box-100"><!-- box full-width -->
      <div class="boxin">
        <div class="header">
          <h3>[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h3>
          <?php if($this->configuration->hasFilterForm()): ?>
          <a class="button" href="#" rel="#filtros">[?php echo __('Filters') ?] »</a>
          [?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('class' => 'button altbutton','query_string' => '_reset', 'method' => 'post')) ?]
          <?php endif;?>
        </div>
        <div class="content">
  <?php if ($this->configuration->getValue('list.batch_actions')): ?>
      <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
  <?php endif; ?>
      [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
      <ul class="actions">
        [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
        [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
      </ul>
  <?php if ($this->configuration->getValue('list.batch_actions')): ?>
      </form>
  <?php endif; ?>
        </div>
      </div>
    </div>

<?php if ($this->configuration->hasFilterForm()): ?>
    <div id="filtros" class="box box-50 simple_overlay"><!-- box full-width -->
      <div class="boxin">
        <div class="header">
          <h3>[?php echo __('Filters', array(), 'sf_admin') ?]</h3>
        </div>
        <div class="content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
        </div>
      </div>
    </div>
  <script>
// What is $(document).ready ? See: http://flowplayer.org/tools/documentation/basics.html#document_ready
$(document).ready(function() {
    $("a[rel]").overlay({
		mask: '#000',
                top: 	'15%'
    });
});
</script>  
<?php endif; ?>



  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
</div>
