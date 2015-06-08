<?php sfMediaBrowserUtils::loadAssets('list') ?>
<?php use_helper('I18N', 'Text') ?>
<?php $upload_form->getWidgetSchema()->setFormFormatterName('list') ?>
<?php $dir_form->getWidgetSchema()->setFormFormatterName('list') ?>
<div id="" style="width:930px;padding-bottom:0.5em;margin:0 auto;">
<div id="sf_media_browser_user_message"></div>

<div id="sf_media_browser_forms">
  <div class="clear"></div>
</div>

<?php if($sf_user->hasFlash('error')): ?>
  <div class="error">
  <?php if($sf_user->getFlash('error') == 'directory.delete'): ?>
    <?php echo __('The directory could not be deleted.') ?>
  <?php elseif($sf_user->getFlash('error') == 'file.create'): ?>
    <?php echo __('The file could not be uploaded.') ?>
  <?php elseif($sf_user->getFlash('error') == 'directory.create'): ?>
    <?php echo __('The directory could not be created.') ?>
  <?php endif ?>
  </div>
<?php elseif($sf_user->hasFlash('notice')): ?>
  <div class="notice">
  <?php if($sf_user->getFlash('notice') == 'directory.create'): ?>
    <?php echo __('The directory was successfully created.') ?>
  <?php elseif($sf_user->getFlash('notice') == 'directory.delete'): ?>
    <?php echo __('The directory was successfully deleted.') ?>
  <?php elseif($sf_user->getFlash('notice') == 'file.create'): ?>
    <?php echo __('The file was successfully uploaded.') ?>
  <?php elseif($sf_user->getFlash('notice') == 'file.delete'): ?>
    <?php echo __('The file was succesfully deleted.') ?>
  <?php endif ?>
  </div>
<?php endif ?>
<script type="text/javascript">
//<![CDATA[
function ShowHideFile(){
    $("#res_form_file").animate({"height": "toggle"}, { duration: 1000 });
    $("#res_form_dir").slideUp();
}

function ShowHideDir(){
    $("#res_form_file").slideUp();
    $("#res_form_dir").animate({"height": "toggle"}, { duration: 1000 });
}
//]]>
</script>

<div style="width:100%">
    <div style="width:200px;float: left">
       <?php if($display_dir!='/'):?>
           <h3>Opciones:</h3>
           <p style="margin-left:10px">
           <?php if($display_dir!='/archivos'):?>
           <a onclick="ShowHideDir(); return false;" href="#">Crear un directorio</a><br>
           <?php endif;?>
           <?php echo link_to(__('Subir multiples archivos'),'@sf_media_browser_upload_multi?dir='.$display_dir)?><br> 
           <a onclick="ShowHideFile(); return false;" href="#">Subir un archivo</a>          
           </p>
       <?php endif;?>
       <?php include_component('sfMediaBrowser', 'tree'); ?>
       
    </div>
    <div style="width:700px;float: right">
        <div id="res_form_file" style="display:none">
            <h3><?php echo __('Upload a file') ?></h3>
            <form action="<?php echo url_for('sf_media_browser_file_create') ?>" method="post" enctype="multipart/form-data">
              <?php echo $upload_form ?>
              <input type="submit" class="submit" value="<?php echo __('Save') ?>" />
            </form>
        </div>
        <div id="res_form_dir" style="display:none">
            <h3><?php echo __('Create a new directory') ?></h3>
            <form action="<?php echo url_for('sf_media_browser_dir_create') ?>" method="post">
              <?php echo $dir_form ?>
              <input type="submit" class="submit" value="<?php echo __('Create') ?>" />
            </form>
        </div>

<h3><?php echo sprintf(__('Current directory : %s'), $display_dir) ?></h3>


<ul id="sf_media_browser_list">

  <?php if($parent_dir): ?>
  <li class="up"  style="border:none">
    <div class="icon">
      <?php echo link_to(image_tag('/sfMediaBrowserPlugin/images/icons/up.png'), $current_route, array_merge($sf_data->getRaw('current_params'), array('dir' => $parent_dir))) ?>
    </div>
  </li>
  <?php endif ?>

<?php foreach($dirs as $dir): ?>
  <li class="folder">
    <div class="icon">
      <?php echo link_to(image_tag('/sfMediaBrowserPlugin/images/icons/folder.png'), $current_route, array_merge($sf_data->getRaw('current_params'), array('dir' => $relative_dir.'/'.$dir)), array('title' => $dir)) ?>
    </div>
    <label class="name"><?php echo $dir ?></label>
    <div class="action">
        <?php if(!in_array($dir, sfConfig::get('app_sf_media_browser_undelete_dir'))): ?>
            <?php echo link_to('delete', 'sf_media_browser_dir_delete', array('sf_method' => 'delete', 'directory' => urlencode($relative_dir.'/'.$dir)), array('class' => 'delete', 'title' => sprintf(__('Delete folder "%s"'), $dir))) ?>
        <?php endif;?>
    </div>
  </li>
<?php endforeach ?>

<?php foreach($files as $file): ?>
  <li class="file">
    <?php include_component('sfMediaBrowser', 'icon', array('file_url' => $relative_url.'/'.$file, 'relative_dir' => $relative_dir)) ?>
  </li>
<?php endforeach ?>
</ul>

 </div>
</div>

<script type="text/javascript">
var delete_msg = "<?php echo __('Are you sure you want to delete this item ?') ?>";
var move_file_url = "<?php echo url_for('sf_media_browser_move') ?>";
var rename_file_url = "<?php echo url_for('sf_media_browser_rename') ?>";
</script>

</div>
<div class="clear"></div>