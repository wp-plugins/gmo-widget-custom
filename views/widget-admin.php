<?php
/**
 * Widget Custom admin template
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

	$id_prefix = $this->get_field_id('');
?>

<div class="uploader">
	<h5><?php _e('Margin', 'widget_custom'); ?></h5>
        <p>
           <label for="<?php echo $this->get_field_id('body'); ?>">
           <?php _e('Input a numerical value. ex:10', 'widget_custom'); ?>
           </label>
           <input  class="widefat" type="text" id="<?php echo $this->get_field_id('body'); ?>" name="<?php echo $this->get_field_name('body'); ?>" value="<?php echo $instance['body']; ?>" />
			<?php _e('This margin', 'widget_custom'); ?>:<?php echo ''.$instance['body'].'px'; ?>
        </p>
        
        <h5><?php _e('Image', 'widget_custom'); ?></h5>

	<input type="submit" class="button" name="<?php echo $this->get_field_name('uploader_button'); ?>" id="<?php echo $this->get_field_id('uploader_button'); ?>" value="<?php _e('Select an Image', 'widget_custom'); ?>" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' ); return false;" />
	<div class="tribe_preview" id="<?php echo $this->get_field_id('preview'); ?>">
		<?php echo $this->get_image_html($instance, false); ?>
	</div>
	<input type="hidden" id="<?php echo $this->get_field_id('attachment_id'); ?>" name="<?php echo $this->get_field_name('attachment_id'); ?>" value="<?php echo abs($instance['attachment_id']); ?>" />
	<input type="hidden" id="<?php echo $this->get_field_id('imageurl'); ?>" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $instance['imageurl']; ?>" />
</div>
<br clear="all" />

<div id="<?php echo $this->get_field_id('fields'); ?>" <?php if ( empty($instance['attachment_id']) && empty($instance['imageurl']) ) { ?>style="display:none;"<?php } ?>>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'widget_custom'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['title'])); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alternate Text', 'widget_custom'); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['alt'])); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Caption', 'widget_custom'); ?>:</label>
	<textarea rows="8" class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo format_to_edit($instance['description']); ?></textarea></p>

	<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'widget_custom'); ?>:</label>
	<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['link'])); ?>" /><br />
	<select name="<?php echo $this->get_field_name('linktarget'); ?>" id="<?php echo $this->get_field_id('linktarget'); ?>">
		<option value="_self"<?php selected( $instance['linktarget'], '_self' ); ?>><?php _e('Stay in Window', 'widget_custom'); ?></option>
		<option value="_blank"<?php selected( $instance['linktarget'], '_blank' ); ?>><?php _e('Open New Window', 'widget_custom'); ?></option>
	</select></p>


	<?php
	// Backwards compatibility prior to storing attachment ids
	?>
	<div id="<?php echo $this->get_field_id('custom_size_selector'); ?>" <?php if ( empty($instance['attachment_id']) && !empty($instance['imageurl']) ) { $instance['size'] = self::CUSTOM_IMAGE_SIZE_SLUG; ?>style="display:none;"<?php } ?>>
		<p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size', 'widget_custom'); ?>:</label>
			<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" onChange="imageWidget.toggleSizes( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' );">
				<?php
				// Note: this is dumb. We shouldn't need to have to do this. There should really be a centralized function in core code for this.
				$possible_sizes = apply_filters( 'image_size_names_choose', array(
					'full'      => __('Full Size', 'widget_custom'),
					'thumbnail' => __('Thumbnail', 'widget_custom'),
					'medium'    => __('Medium', 'widget_custom'),
					'large'     => __('Large', 'widget_custom'),
				) );
				$possible_sizes[self::CUSTOM_IMAGE_SIZE_SLUG] = __('Custom', 'widget_custom');

				foreach( $possible_sizes as $size_key => $size_label ) { ?>
					<option value="<?php echo $size_key; ?>"<?php selected( $instance['size'], $size_key ); ?>><?php echo $size_label; ?></option>
					<?php } ?>
			</select>
		</p>
	</div>
	<div id="<?php echo $this->get_field_id('custom_size_fields'); ?>" <?php if ( empty($instance['size']) || $instance['size']!=self::CUSTOM_IMAGE_SIZE_SLUG ) { ?>style="display:none;"<?php } ?>>

		<input type="hidden" id="<?php echo $this->get_field_id('aspect_ratio'); ?>" name="<?php echo $this->get_field_name('aspect_ratio'); ?>" value="<?php echo $this->get_image_aspect_ratio( $instance ); ?>" />

		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width', 'widget_custom'); ?>:</label>
		<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['width'])); ?>" onchange="imageWidget.changeImgWidth( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' )" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height', 'widget_custom'); ?>:</label>
		<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['height'])); ?>" onchange="imageWidget.changeImgHeight( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' )" size="3" /></p>

	</div>

	<p><label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Align', 'widget_custom'); ?>:</label>
	<select name="<?php echo $this->get_field_name('align'); ?>" id="<?php echo $this->get_field_id('align'); ?>">
		<option value="none"<?php selected( $instance['align'], 'none' ); ?>><?php _e('none', 'widget_custom'); ?></option>
		<option value="left"<?php selected( $instance['align'], 'left' ); ?>><?php _e('left', 'widget_custom'); ?></option>
		<option value="center"<?php selected( $instance['align'], 'center' ); ?>><?php _e('center', 'widget_custom'); ?></option>
		<option value="right"<?php selected( $instance['align'], 'right' ); ?>><?php _e('right', 'widget_custom'); ?></option>
	</select></p>
</div>