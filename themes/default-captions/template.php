<div id='gallery-container-<?php echo $id; ?> gallery_container_<?php echo $name_space; ?>-<?php echo $id; ?>' class='gallery-container gallery_container_<?php echo $name_space; ?>'>
	<!-- Navigation -->
	
		<a id='galleryPrev-<?php echo $id; ?>' class='gallery-prev gallery-button' href='#'><?php echo $previous; ?></a>
		 / <a id='galleryNext-<?php echo $id; ?>' class='gallery-next gallery-button' href='#'><?php echo $next; ?></a>
		<span id='galleryNumbering-<?php $id; ?>' class='gallery-numbering' data-numbering-translation-of='<?php echo $number_translation; ?>'></span>
	</div>

	<!-- Start Gallery -->
	<div id='galleryid-<?php echo $id; ?>' data-total='<?php $count; ?>'class='gallery galleryid-<?php echo $id; ?> gallery-columns-<?php echo $columns; ?> gallery-size-<?php echo $size_class; ?>'>
		<!-- Include all images as HTML -->
		<?php echo $images; ?>
	</div>
	<!-- Start Gallery Pager -->
	<div id='gallery-pager-<?php echo $id; ?>' class='gallery-pager'></div>
	<!-- Clear Container -->
	<div style='clear:both;'></div>
<!-- Finish Gallery Container -->
</div>