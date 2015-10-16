<?php
/* Category header */
if( is_category() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php printf( __('You are viewing the <span>%s</span> category archive.', 'apex'), single_cat_title('', false) ); ?>
		</h2>
		<?php if ( category_description() ) echo category_description(); ?>
	</div>
<?php
}
/* Tag header */
elseif( is_tag() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php printf( __('You are viewing the <span>%s</span> tag archive.', 'apex'), single_tag_title('', false) ); ?>
		</h2>
		<?php if ( tag_description() ) echo tag_description(); ?>
	</div>
<?php
}
/* Author header */
elseif( is_author() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php printf( __("You are viewing <span>%s</span>'s post archive.", "apex"), get_the_author_meta( 'display_name' ) ); ?>
		</h2>
		<?php if ( get_the_author_meta( 'description' ) ) echo '<p>' . get_the_author_meta( 'description' ) . '</p>'; ?>
	</div>
<?php
}
/* Date header */
elseif( is_date() ){ ?>
	<div class='archive-header'>
		<h2>
			<?php printf( __('You are viewing the date archive for <span>%s</span>.', 'apex'), single_month_title('', false) ); ?>
		</h2>
	</div>
<?php
}