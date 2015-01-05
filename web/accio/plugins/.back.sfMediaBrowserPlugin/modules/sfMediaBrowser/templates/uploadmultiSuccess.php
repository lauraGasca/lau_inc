<?php sfMediaBrowserUtils::loadAssets('list') ?>
<?php $resize='';?>
<?php if(strstr($dir_upload, '/archivos')):?>
<?php $file_type='title : "Docs and Audio Files", extensions : "pdf,doc,ppt,mp3"';?>
<?php endif;?>
<?php if(strstr($dir_upload, '/galeria')):?>
<?php $file_type='title : "Image files", extensions : "jpg,gif,png,JPG,PNG"';?>
<?php $resize='resize :{width : 800, height : 600, quality : 85},';?>
<?php endif;?>
<?php if(strstr($dir_upload, '/Image')):?>
<?php $file_type='title : "Image files", extensions : "jpg,gif,png,JPG,PNG"';?>
<?php $resize='resize :{width : 400, height : 300, quality : 80},';?>
<?php endif;?>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
        $("#uploader").pluploadQueue({
		// General settings
		runtimes : 'flash',
		url : '<?php echo url_for('@sf_media_browser_plupload');?>',
		max_file_size : '10mb',
		chunk_size : '1mb',
		unique_names : true,

		// Resize images on clientside if we can
		<?php echo $resize; ?>

                // Specify what files to browse for
	        filters : [
	            {<?php echo $file_type; ?>}
	        ],

		// Flash settings
		flash_swf_url : '/sfMediaBrowserPlugin/js/plupload/plupload.flash.swf'
	});



	// Client side form validation
	$('form').submit(function(e) {
		var uploader = $('#uploader').pluploadQueue();

		// Validate number of uploaded files
		if (uploader.total.uploaded == 0) {
			// Files in queue upload them first
			if (uploader.files.length > 0) {
				// When all files are uploaded submit form
				uploader.bind('UploadProgress', function() {
					if (uploader.total.uploaded == uploader.files.length)
						$('form').submit();
				});

				uploader.start();
			} else
				alert('You must at least upload one file.');

			e.preventDefault();
		}
	});
});
</script>

<div id="" style="width:950px;padding-bottom:0.5em;margin:0 auto;">
    <h3>Subida de multiples archivos</h3>
    <p>Se subiran los archivos al directorio <b><i><?php echo $dir_upload?></i></b></p>
<form method="post" action="<?php echo url_for('@sf_media_browser_files_create_multi')?>" enctype="multipart/form-data" accept-charset="utf-8">
<input type="hidden" name="dir" id="dir" value="<?php echo $dir_upload?>">
<div id="uploader">
    <p>Tu navegador no soporta Flash</p>
</div>   
</form>
</div>