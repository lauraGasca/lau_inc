[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container">


  <div id="box1" class="box box-100"><!-- box full-width -->
    <div class="boxin">
      <div class="header">
        <h3>[?php echo <?php echo $this->getI18NString('new.title') ?> ?]</h3>
        <!-- the tabs -->
        <ul class="tabs">
            [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
                [?php if($fieldset!='NONE'): ?]
                  <li><a href="#[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">[?php echo $fieldset ?]</a></li>
                [?php endif; ?]
            [?php endforeach; ?]
        </ul>
      </div>
      <span class="content">

        [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

        <div id="sf_admin_header">
          [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>

        <div id="sf_admin_content">
          [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
        </div>

        <div id="sf_admin_footer">
          [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
        </div>
      </span>
    </div>
  </div>
</div>
