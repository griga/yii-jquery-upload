<!-- The file upload form used as target for the file upload widget -->
<?php /** @var $this XUpload */ ?>
<?php if ($this->showForm) echo CHtml::beginForm($this->url, 'post', $this->htmlOptions); ?>
<div class="row fileupload-buttonbar">
	<div class="span8">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
			<?php
			if ($this->hasModel()) :
				echo CHtml::activeFileField($this->model, $this->attribute, $htmlOptions) . "\n"; else :
				echo CHtml::fileField($name, $this->value, $htmlOptions) . "\n";
			endif;
			?>
		</span>
	</div>
	<div class="span4">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped files-table">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
	<?php if (count($this->alreadyUploaded) > 0): ?>
		<?php foreach ($this->alreadyUploaded as $thumb): ?>
			<tr class="template-download fade in" style="height: 82px;">
				<td class="preview">
					<img src="<?php echo $thumb ?>">
				</td>

				<td>
					<?php echo
					CHtml::ajaxSubmitButton('Удалить',Yii::app()->createUrl('admin/image/erase'),
						array(
							'data'=>array(
								'thumb'=>$thumb,
							),
							'success'=>'js:function(response){ deleteImageRow(response.thumb)}',
							'dataType'=>'JSON'
						),
						array(
							'confirm'=>'Точно удалить?',
							'class'=>'btn btn-danger'
						)
					);?>

				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
<script type="text/javascript">
	function deleteImageRow(thumb){
		var $img = $('img[src^="'+thumb+'"]');
		$img.closest('tr').fadeOut('fast',function(){$(this).remove()});
	}
</script>

<?php if ($this->showForm) echo CHtml::endForm(); ?>