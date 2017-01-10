<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'color_background' ); ?>"><?php _e( 'Background Color', 'fpcs-basic-social-widget' ); ?></label><br>
	<input type="text" name="<?php echo $this->get_field_name( 'color_background' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'color_background' ); ?>" value="<?php echo $color_background; ?>" data-default-color="#2b2b2b" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'color_background_hover' ); ?>"><?php _e( 'Background Hover Color', 'fpcs-basic-social-widget' ); ?></label><br>
	<input type="text" name="<?php echo $this->get_field_name( 'color_background_hover' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'color_background_hover' ); ?>" value="<?php echo $color_background_hover; ?>" data-default-color="#333333" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'LinkedIn URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $linkedin; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'googleplus' ); ?>"><?php _e( 'Google+ URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus' ); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" type="text" value="<?php echo $googleplus; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instagram; ?>" /></p>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest URL', 'fpcs-basic-social-widget' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo $pinterest; ?>" /></p>
</p>
<p>
	<input id="<?php echo $this->get_field_id('enqueue_fa'); ?>" name="<?php echo $this->get_field_name('enqueue_fa'); ?>" type="checkbox"<?php checked( $enqueue_fa ); ?> />&nbsp;
	<label for="<?php echo $this->get_field_id('enqueue_fa'); ?>"><?php _e('Enqueue Font Awesome CSS'); ?></label>
</p>