<?php
/*
Plugin Name: amr breadcrumb
Plugin URI: http://webdesign.anmari.com/category/plugins/amr-breadcrumb/
Description: Provides a  breadcrumb navigation trail.  It has options for a title, a separator (not recommended, but provided for), a provided background image, and an and option to switch off styling if you wish to use your own styling.   
Author: Anmari
Version: 1.6
Author URI: http://webdesign.anmari.com
Text Domain: amr-breadcrumb
Domain Path:  /lang

*/
class breadcrumb_navigation_widget extends WP_widget {
    /** constructor */
    function __construct() {
		$widget_ops = array ('description'=>__('Breadcrumbs', 'breadcrumb-navigation-widget' ),'classname'=>__('crumbs', 'amr-ical-events-list' ));
        parent::__construct(false, __('Breadcrumbs', 'breadcrumb-navigation-widget' ), $widget_ops);	
    }
	
function widget($args, $instance){
	global $notfound;
	global $post;
		
	extract ($instance, EXTR_SKIP); /* this is for the before / after widget etc*/	
    extract($args, EXTR_SKIP); /* should now have $titel, $separator, $nobackground_image, $nostyle*/

		if (!(is_null($sep))) $sep = '<span>'.$sep.'</span>';

		if (is_page())	{
			$p_id = $post->ID;
			$p = get_page($p_id);
			$trail = array($p_id);
			while ($p->post_parent ) /* while we have a parent, save the parent and go up again  */
			{	$p_id = $p->post_parent;
				array_unshift($trail, $p_id);
				$p = get_page($p_id);
			}
		}	
		else { // we are an archive or a post - show home as the trail
			$trail = array();
		}

			$lvl = 1;
			//output...
			echo $before_widget;
			echo  $before_title . $title . $after_title . "\n<ul>";
			if (!empty($top)) echo '<li><a href="'.get_home_url().'" title="'.$top.'">'.$top.'</a>'.$sep.'</li>';
			if (count($trail)>0) /* if we have a trail */	
			{
				foreach ($trail as $t)	{ /* for each page id in the trail get it's title etc and print it out */
					$t_post = get_page($t);
					$title = esc_html($t_post->post_title);

					$link = get_page_link($t_post->ID);
					$class = "page_item lvl".$lvl;
					if ($t == $post->ID) $class .= " current_page_item";
					echo "<li class=\"$class\"><a href=\"$link\" title=\"$title\">".$title."</a>".$sep."</li>";
					$lvl = $lvl+1;
					}
			}
			echo "\n</ul>".$after_widget;

}

/* ============================================================================= */	
	
	function update($new_instance, $old_instance) {  /* this does the update / save */

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['nostyle'] = strip_tags($new_instance['nostyle']);
		$instance['nobackground_image'] = strip_tags($new_instance['nobackground_image']);
		$instance['sep'] = strip_tags($new_instance['sep']);
		$instance['top'] = strip_tags($new_instance['top']);
		
		update_option('amr_breadcrumb_nostyle',$instance['nostyle'] );
		update_option('amr_breadcrumb_nobackground_image',$instance['nobackground_image'] );
		
		return $instance;

	}


/* =============================================================================== */
	function form($instance) { /* this does the display form */
		load_plugin_textdomain('amr-breadcrumb', false , dirname(plugin_basename(__FILE__)).'/lang' );
	
        $instance = wp_parse_args( (array) $instance, array( 
			'title' => 'Breadcrumb trail',
			'sep' => ' >> ',
			'top' => __('Home','amr-breadcrumb'),
			'nostyle' => '' ,
			'nobackground_image' => 'NoBackgroundImage'	));
			
		$title = $instance['title'];
		$sep = $instance['sep'];
		$top = $instance['top'];
		$nostyle = $instance['nostyle'];
		$nobackground_image = $instance['nobackground_image'];

	$checked2 = $checked = '';
	if ($nostyle === 'NoDefaultStyle') $checked = ' checked="checked"';  
	if ($nobackground_image === 'NoBackgroundImage') $checked2 = ' checked="checked"';  
?>
	<input type="hidden" id="amr_breadcrumb_submit" name="amr_breadcrumb_submit" value="1" />

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'amr-breadcrumb'); ?> 
	<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" 
	value="<?php echo esc_attr($title); ?>" />		</label></p>
	
	<p><label for="<?php echo $this->get_field_id('top'); ?>"><?php _e('Show top level as', 'amr-breadcrumb'); ?> 
	<input id="<?php echo $this->get_field_id('top'); ?>" name="<?php echo $this->get_field_name('top'); ?>" type="text" 
	value="<?php echo esc_attr($top); ?>" />		</label></p>
	
	<p><label for="<?php echo $this->get_field_id('nostyle'); ?>"><?php _e('No default Style?', 'amr-breadcrumb'); ?> 
	<input id="<?php echo $this->get_field_id('nostyle'); ?>" name="<?php echo $this->get_field_name('nostyle'); ?>" type="checkbox" 
	value="NoDefaultStyle" <?php echo $checked; ?> /></label></p>
	
	<p><label for="<?php echo $this->get_field_id('nobackground_image'); ?>"><?php _e('No background Image?', 'amr-breadcrumb'); ?> 
	<input id="<?php echo $this->get_field_id('nobackground_image'); ?>" name="<?php echo $this->get_field_name('nobackground_image'); ?>" type="checkbox" 
	value="NoBackgroundImage" <?php echo $checked2; ?> /></label></p>
	
	<p><label for="<?php echo $this->get_field_id('sep'); ?>"><?php _e('Separator', 'amr-breadcrumb'); ?> 
	<input id="<?php echo $this->get_field_id('sep'); ?>" name="<?php echo $this->get_field_name('sep'); ?>" type="text" 
	value="<?php echo esc_attr($sep); ?>" />		</label></p>
	
	
<?php
	}	
}

function amr_breadcrumb_style() {

	$nostyle =	get_option('amr_breadcrumb_nostyle');
	$nobkimage = get_option('amr_breadcrumb_nobackground_image' );
		
	$nostyle = (empty($nostyle)) ? null : $nostyle;
	$nobkimage = (empty($nobkimage)) ? null : $nobkimage;
	
	if (!($nostyle === 'NoDefaultStyle'))  /* then not using their own style */
	{
		if (!($nobkimage))
			wp_register_style('amr_breadcrumb', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/breadcrumbbackimage.css', array( ), false , 'all' );
		else 
			wp_register_style('amr_breadcrumb', WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/breadcrumbnoimage.css', array( ), false , 'all' );
			
		wp_enqueue_style('amr_breadcrumb' ); 

	}

}

function amr_breadcrumb_init() {
   register_widget("breadcrumb_navigation_widget");
}

add_action('widgets_init', 'amr_breadcrumb_init');	
add_action('wp_print_styles', 'amr_breadcrumb_style' );
?>