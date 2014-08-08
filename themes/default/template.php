<div id='<?php echo $name_space; ?>-gallery-container-<?php echo $id; ?>' class='gallery-container <?php echo $name_space; ?>-gallery-container'>
	<!-- Navigation -->
	<div class='gallery-navigation'>
		<a id='<?php echo $name_space; ?>-gallery-prev-<?php echo $id; ?>' class='gallery-prev gallery-button <?php echo $prev_class; ?>' href='#'><?php echo $previous_text; ?></a>
		 / <a id='<?php echo $name_space; ?>-gallery-next-<?php echo $id; ?>' class='gallery-next gallery-button <?php echo $next_class; ?>' href='#'><?php echo $next_text; ?></a> 
		<span id='<?php echo $name_space; ?>-gallery-numbering-<?php echo $id; ?>' class='gallery-numbering <?php echo $numbering_class; ?>' data-total="<?php echo $count; ?>" data-numbering-translation-of='<?php echo $number_translation; ?>'></span>
	</div>

	<!-- Start Gallery -->
	<div id='<?php echo $name_space; ?>-gallery-<?php echo $id; ?>' data-total='<?php $count; ?>' class='<?php echo $name_space; ?>-gallery gallery gallery-columns-<?php echo $columns; ?> gallery-size-<?php echo $size_class; ?> <?php echo $selector; ?>'>
		<!-- Include all images as HTML -->
		<?php echo $images; ?>
	</div>
	<!-- Start Gallery Pager -->
	<div id='<?php echo $name_space; ?>-gallery-pager-<?php echo $id; ?>' class='gallery-pager <?php echo $pager_class; ?>'></div>
	<!-- Clear Container -->
	<div style='clear:both;'></div>
<!-- Finish Gallery Container -->
</div>