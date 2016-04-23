<?php
class MASHOG_OG_Output {

	protected $_metas = array();

	public function __construct(){
		global $wpseo_og;
		remove_filter('language_attributes', array($wpseo_og, 'add_opengraph_namespace'), 11);
		remove_action('wp_head', 'jetpack_og_tags');
		add_filter('language_attributes', array($this, 'add_og_attribute'), 12);
		add_action('wp_head', array($this, 'add_og_elements'));
	}

	public function add_og_elements(){
            global $mashsb_options;
		$this->_metas['og:site_name'] = strip_tags(get_bloginfo('name'));
		$this->_metas['og:locale'] = strtolower(str_replace('-', '_', get_bloginfo('language')));
		$this->_metas['og:type'] = $this->_get_type();
		/*$img = $this->_add_image();
		if($img)
			$this->_metas['og:image'] = $img;*/
		
		if(is_home()){
			$this->_metas['og:title'] = $mashsb_options['mashog_blog_title'];
			
			$posts_page_id = get_option('page_for_posts');
			if($posts_page_id) {			
				$this->_metas['og:url'] = get_permalink($posts_page_id);
			} else {
				$this->_metas['og:url'] = home_url();
			}
			$this->_metas['og:description'] = $mashsb_options['mashog_blog_desc'];
			$this->_add_image();
		}
		else if(is_front_page()){
			$this->_metas['og:title'] = $mashsb_options['mashog_blog_title'];
			$this->_metas['og:url'] = home_url();
			$this->_metas['og:description'] = stripslashes($mashsb_options['mashog_homepage_desc']);
			$this->_add_image();
		}
		else if (is_singular()) {
			the_post();
			$this->_metas['og:title'] = $this->_get_title();
			$this->_metas['og:url'] = get_permalink();
			$this->_metas['og:description'] = $this->_get_description();
			$this->_add_image();
			rewind_posts();
		}
		else if(is_tax() OR is_category() OR is_tag()){
			$this->_metas['og:title'] = $this->get_tax_data('title');
			$this->_metas['og:url'] = $this->get_tax_data('link');
			$description = $this->get_tax_data('description');
			if($description)
				$this->_metas['og:description'] = $description;
			
			$image = $mashsb_options['mashog_default_image'];
			if($image)
				$this->_metas['og:image'] = $image;
		}
		$this->_output();
	}
	
	protected function get_tax_data($data){
		if(!$data)
			return;
		global $wp_query;
		$term = $wp_query->get_queried_object();
		
		if($data == 'title')
			return $term->name;
			
		if($data == 'description')
			return strip_tags($term->description);
			
		if($data == 'link') {
			$link = get_term_link($term);
			return $link;
		}
	}
	
	public function add_app_id() {
		$app_id = MASHOG_OG_Main_Admin::option('fb_app_id');
		if($app_id)
			echo '<meta prefix="fb: http://ogp.me/ns/fb#" property="fb:app_id" content="' . $app_id . '" />' . "\n";
		
		$fb_admin = MASHOG_OG_Main_Admin::option('fb_admin');
		if($fb_admin)
		echo '<meta property="fb:admins" content="' . $fb_admin . '" />' . "\n";
	}
	
	public function add_og_attribute() {
		return ' prefix="og: http://ogp.me/ns#"';
	}
	
	public function _get_title(){
		$title = null;
		if(get_post_meta(get_the_ID(), '_og_title', TRUE)){
			$title = get_post_meta(get_the_ID(), '_og_title', TRUE);
		}
		else if (function_exists('aioseop_get_version')) {
			$title = trim(get_post_meta(get_the_ID(), '_aioseop_title', true));
		}
		else if (function_exists('wpseo_get_value')){
			$title = WPSEO_Meta::get_value('title', get_the_ID() );
		}
		return empty($title) ? the_title_attribute('echo=0') : $title;
	}
        
        public function _get_tw_title(){
		$tw_title = null;
		if(get_post_meta(get_the_ID(), 'mashog_tw_title', TRUE)){
			$tw_title = get_post_meta(get_the_ID(), 'mashog_tw_title', TRUE);
		}
		return empty($tw_title) ? the_title_attribute('echo=0') : $tw_title;
	}
	
	public function _get_type(){
            global $mashsb_options;
		$type = null;

		if(is_front_page()){
			$home_type = $mashsb_options['mashog_homepage_type'];
			if($home_type) {
				$type = $home_type;
			} else {
				$type = 'website';
			}
		}
		else if(is_home()){
			$blog_type = $mashsb_options['mashog_blog_type'];
			if($blog_type) {
				$type = $blog_type;
			} else {
				$type = 'blog';
			}
		} else {
			if(get_post_meta(get_the_ID(), '_og_type', TRUE)){
				$type = get_post_meta(get_the_ID(), '_og_type', TRUE);
			}
			else {
				$type = 'article';
			}
		}

		return $type;
	}

	public function _get_description(){
            global $mashsb_options;
		$description = null;
                if(is_front_page()){
                        !empty($mashsb_options['mashog_homepage_desc']) ?  $description = $mashsb_options['mashog_homepage_desc'] : $description = 'test2';
                } 
                else if(get_post_meta(get_the_ID(), '_og_description', TRUE)){
			$description = get_post_meta(get_the_ID(), '_og_description', TRUE);
		}
		else if (function_exists('aioseop_get_version')) {
			$description = trim(get_post_meta(get_the_ID(), '_aioseop_description', true));
		}
		else if (function_exists('wpseo_get_value')){
			$description = WPSEO_Meta::get_value('metadesc', get_the_ID() );
		}
		//return empty($description) ? strip_tags(get_the_excerpt()) : $description;
                return empty($description) ? $mashsb_options['mashog_homepage_desc'] : $description;
	}
        
        public function _get_hashtag(){
		$hashtag = null;
		if(get_post_meta(get_the_ID(), '_tw_hashtag', TRUE)){
			$hashtag = get_post_meta(get_the_ID(), '_tw_hashtag', TRUE);
		}
		
		return empty($hashtag) ? '' : $hashtag;
	}

	public function _add_image($admin_img=false){
            global $mashsb_options;
		$default_image = $mashsb_options['mashog_default_image'];
                $home_image = $mashsb_options['mashog_homepage_image'];
		if(is_front_page()){
			
			if($home_image){
				$this->_metas['og:image'] = $home_image;
                                return $home_image;
			}
			else if ($default_image) {
						$this->_metas['og:image'] = $default_image;
						return $default_image;
				}
		}
		else if(is_home()){
			$blog_image = $mashsb_options['mashog_blog_image'];
			if($home_image){
				$this->_metas['og:image'] = $blog_image;
                                return $home_image;
			}
			else if ($default_image) {
						$this->_metas['og:image'] = $default_image;
						return $default_image;
				}
		}
		else {
			if (has_post_thumbnail()) {				
				$this->_metas['og:image'] = wp_get_attachment_url(get_post_thumbnail_id());
				if($admin_img) {
					$img = wp_get_attachment_image( get_post_thumbnail_id(), array(117,117) );
					return $img;
				}
				return wp_get_attachment_url(get_post_thumbnail_id());
			}
			else {
				$attachment = get_posts(array( 'numberposts' => 1, 'post_type'=>'attachment', 'post_parent' => get_the_ID() ));
				if ($attachment) {
					$this->_metas['og:image'] = wp_get_attachment_thumb_url($attachment[0]->ID);
					if($admin_img) {
						$img = wp_get_attachment_image( $attachment[0]->ID, array(117,117) );
						return $img;
					}
					return wp_get_attachment_thumb_url($attachment[0]->ID);
				}
				else {					
					if ($default_image) {
						$this->_metas['og:image'] = $default_image;
						if($admin_img) {
							return '<img width="117" src="' . $default_image . '" />';
						}
						return $default_image;
					}
					else {
						return false;
					} 
				}
				wp_reset_query();
			}
		}
	}

	protected function _output(){
		echo "<!-- Open Graph Meta Data by Mashshare.net Open Graph Add-On-->\n";
		foreach ($this->_metas as $property => $content) { 
			$content = is_array($content) ? $content : array($content);
			foreach ($content as $content_single) {
				echo '<meta property="' . $property . '" content="' . esc_attr(trim($content_single)) . '" />' . "\n";
			} 
		}
		//$this->add_app_id();
		echo "<!-- /Open Graph Meta Data -->\n";
	}
}