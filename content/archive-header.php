<?php
/* Category header */
if( is_category() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php printf( __('You are viewing the <span>%s</span> category archive', 'apex'), single_cat_title('', false) ); ?>
		</h2>
	</div>
<?php
}
/* Tag header */
elseif( is_tag() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php _e('Tag archive for:', 'apex'); ?>
			<?php single_tag_title(); ?>
		</h2>
	</div>
<?php
}
/* Author header */
elseif( is_author() ){
	$author = get_userdata(get_query_var('author')); ?>
	<div class='archive-header'>
		<i class="fa fa-user" title="<?php _e('author icon', 'founder'); ?>"></i>
		<h2>
			<?php _e('Author archive for:', 'apex'); ?>
			<?php echo $author->nickname; ?>
		</h2>
	</div>
<?php
}
/* Date header */
elseif( is_date() ){ ?>
	<div class='archive-header'>
		<i class="fa fa-calendar" title="<?php _e('calendar icon', 'founder'); ?>"></i>
		<h2>
			<?php _e('Date archive for:', 'apex'); ?>
			<?php single_month_title(' '); ?>
		</h2>
	</div>
<?php
}