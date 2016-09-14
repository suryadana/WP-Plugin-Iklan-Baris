<?php
/**
* Widget for iklan baris for views listing iklan
*/
// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
	// Base ID of your widget
			'wpb_widget', 

	// Widget name will appear in UI
			__('Iklan Baris Widget', 'wpb_widget_domain'), 

	// Widget description
			array( 'description' => __( 'Iklan Baris widget for the next generation website', 'wpb_widget_domain' ), ) 
			);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		global $wpdb;
		$table_content = $wpdb->prefix . "iklan_baris_content";
		$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

	// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'wpb_widget_domain' );
		$data_iklan = $wpdb->get_results("SELECT * FROM $table_content ORDER BY id_content DESC");
		if($wpdb->num_rows > 0){
			?>
				<div class="wrap-iklan-baris-widget">
					<div id="content-with-slider" style="overflow: hidden; position: relative; height: 25%;">
						<ul>
							<?php foreach ($data_iklan as $data) {?>
								<li>
									<a href="<?php echo $data->content_link;?>" target="_blank">
										<h3 style="margin-bottom: 0px;"><?php echo $data->content_title;?></h3>
										<p style="margin-left: 25px;"><?php echo $data->content_description;?></p>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) . 'slider/jquery.vticker.js';?>"></script>
				<script>
				jQuery(function($){
					$(function() {
						$('#content-with-slider').vTicker();
					});
				});
				</script>
			<?php
		}else{
			?>
				<div class="wrap-iklan-baris-widget">
					<h3>Nothing iklan.</h3>
				</div>
			<?php
		}
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
	// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );