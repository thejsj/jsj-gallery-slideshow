<div
	id='<?php echo $name_space; ?>-gallery-container-<?php echo $id; ?>'
	class='gallery-container <?php echo $name_space; ?>-gallery-container cycle-slideshow <?php echo $theme_name; ?>'
	data-numbering-translation-of='<?php echo $number_translation; ?>'
	data-total='<?php echo $count; ?>'
	data-cycle-auto-init=false
>
	<!-- Navigation -->
	<div class='gallery-navigation'>
		<a id='<?php echo $name_space; ?>-gallery-prev-<?php echo $id; ?>' class='gallery-prev gallery-button <?php echo $prev_class; ?>' href='#'><?php echo $previous_text; ?></a>
		<span class='divider'>/</span>
		<a id='<?php echo $name_space; ?>-gallery-next-<?php echo $id; ?>' class='gallery-next gallery-button <?php echo $next_class; ?>' href='#'><?php echo $next_text; ?></a>
		<span id='<?php echo $name_space; ?>-gallery-numbering-<?php echo $id; ?>' class='gallery-numbering <?php echo $numbering_class; ?>'></span>
	</div>

	<!-- Start Gallery -->
	<div
		id='<?php echo $name_space; ?>-gallery-<?php echo $id; ?>'
		class='gallery gallery-columns-<?php echo $columns; ?> gallery-size-<?php echo $size_class; ?> <?php echo $name_space; ?>-gallery <?php echo $selector; ?> <?php echo $theme_name; ?>'
	>
		<!-- Include all images as HTML -->
		<?php echo $images; ?>
	</div>
	<!-- Start Gallery Pager -->
	<div id='<?php echo $name_space; ?>-gallery-pager-<?php echo $id; ?>' class='gallery-pager <?php echo $pager_class; ?>'></div>
	<!-- Clear Container -->
	<div style='clear:both;'></div>
<!-- Finish Gallery Container -->
</div>