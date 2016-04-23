<?php

/**
 * Admin opengraph
 *
 * @package     MASHOG
 * @subpackage  Admin/opengraph
 * @copyright   Copyright (c) 2014, René Hermenau
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

class MASHOG_OG_Admin{

	public function __construct(){
		add_action( 'add_meta_boxes', array($this, 'mashog_add_og_custom_box') );
                add_action( 'save_post', array($this, '_save_postdata') );
	}

	public function mashog_add_og_custom_box(){
		add_meta_box(
			'mashog_open_graph',
			'Mashshare Open Graph & Sharing Optimization ', 
			array($this, 'mashog_og_custom_box'),
			'',
			'advanced',
			'default'
		);
	}

	public function mashog_og_custom_box( $post ){
                $tw_title = get_post_meta($post->ID, 'mashog_tw_title', TRUE);
		$metatitle = get_post_meta($post->ID, '_og_title', TRUE);
		$metadescription = get_post_meta($post->ID, '_og_description', TRUE);
		$metatype = get_post_meta($post->ID, '_og_type');
                !empty($metatype) ? $metatype = 'article' : $metatype;
                $hashtag = get_post_meta($post->ID, '_tw_hashtag', TRUE);
		?>		
		<table>
                    <tr>
                        <td colspan="2" style="line-height:30px;font-weight: bold;font-size: 13px;">Note: Make sure to disable other 3rd party open graph tags or you' ll run into conflicts.<br>
                            Important: <a href="https://developers.facebook.com/tools/debug/og/object?q=<?php echo get_permalink($post->ID); ?>" target="_blank">Validate Open Graph and fetch new scrape Information</a> after doing changes below!</div>
                    </tr>
			<tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_og_title">Facebook snippet preview:</label>
				</td>
				<td>
					<?php echo $this->_fb_snippet() ?>
				</td>
			</tr>
                        <tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_og_title">Twitter snippet preview:</label>
				</td>
				<td>
					<?php echo $this->_tw_snippet() ?>
				</td>
			</tr>
                        <tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_tw_title">Title used by Twitter:</label>
				</td>
				<td>
					<textarea rows="2" style="width:510px;" cols="72" id="mashog_tw_title" name="mashog_tw_title"><?php if ($tw_title!=FALSE) echo $tw_title; ?></textarea>
				</td>
			</tr>
			<tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_og_title">Open Graph Title<br> used by Facebook:</label>
				</td>
				<td>
					<input type="text" style="width:510px;" id="mashog_og_title" name="mashog_og_title" value="<?php if ($metatitle!=FALSE) echo $metatitle; ?>" size="90" />
				</td>
			</tr>
			<tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_og_description">Open Graph Description<br>used by Facebook:</label>
				</td>
				<td>
					<textarea rows="3" style="width:510px;" cols="72" id="mashog_og_description" name="mashog_og_description"><?php if ($metadescription!=FALSE) echo $metadescription; ?></textarea>
				</td> 
			</tr>
			<tr>
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_og_type">Open Graph Type, default: 'article':</label>
				</td>
				<td>
					<input type="text" style="width:510px;" id="mashog_og_type" name="mashog_og_type" value="<?php echo $metatype; ?>" size="70" />
				</td> 
			</tr>
                        <!--<tr style="display:none;">
				<td style="font-weight: bold;font-size: 13px;">
					<label for="mashog_tw_hashtag">Twitter Hashtags, e.g. #hash1,#hash2:</label>
				</td>
				<td>
					<input type="text" style="width:510px;" id="mashog_tw_hashtags" name="mashog_tw_hashtag" value="<?php //if ($hashtag !=FALSE) echo $hashtag; ?>" size="70" />
				</td> 
			</tr>//-->
		</table>
	<?php
	}

	public function _save_postdata( $post_id ){
                $tw_title = $_POST['mashog_tw_title'];
		$title = $_POST['mashog_og_title'];
		$description = $_POST['mashog_og_description'];
		$type = $_POST['mashog_og_type'];
                $hashtag = $_POST['mashog_tw_hashtag'];
                
		$allpostmeta=get_post_custom($post_id);
                if (array_key_exists('mashog_tw_title', $allpostmeta)){
			update_post_meta($post_id, 'mashog_tw_title', $tw_title);
		}
		else {
			add_post_meta($post_id, 'mashog_tw_title', $tw_title, TRUE);
		}
		if (array_key_exists('_og_title', $allpostmeta)){
			update_post_meta($post_id, '_og_title', $title);
		}
		else {
			add_post_meta($post_id, '_og_title', $title, TRUE);
		}
		if (array_key_exists('_og_type', $allpostmeta)){
			update_post_meta($post_id, '_og_type', $type);
		}
		else {
			add_post_meta($post_id, '_og_type', $type, TRUE);
		}
		if (array_key_exists('_og_description', $allpostmeta)){
			update_post_meta($post_id, '_og_description', $description);
		}
		else {
			add_post_meta($post_id, '_og_description', $description, TRUE);
		}
                if (array_key_exists('_tw_hashtag', $allpostmeta)){
			update_post_meta($post_id, '_tw_hashtag', $hashtag);
		}
		else {
			add_post_meta($post_id, '_tw_hashtag', $hashtag, TRUE);
		}
	}

	function _fb_snippet() {

		if (isset($_GET['post'])) {
			$post_id = (int) $_GET['post'];
		}
		
		//global $MASHOG_OG_Output;

		$content = '<div id="wp_og_snippet" style="border: 1px solid;border-color: #e9eaed #e9eaed #d1d1d1;margin-bottom:10px;">';
		$content .= '<div style="height: 117px;width:117px;float: left; margin-right:10px;">'. MASHOG()->MASHOG_OG_Output->_add_image(true) . '</div>' ;
                $content .= '<div style="padding:7px;"><span style="color: #151515;font-weight: bold;font-size: 14px;">' . MASHOG()->MASHOG_OG_Output->_get_title() . '</span><br />';
		$content .= '<p class="desc" style="width:420px;margin-top: 5px; font-size: 13px; color: #151515;">' .  MASHOG()->MASHOG_OG_Output->_get_description() . '</p>';
                $content .= '<a href="' . get_permalink($post_id) . '" target="_blank" style="font-size: 12px;color: #808080; text-decoration:none;" class="url">' . get_permalink($post_id) . '</a>';

		$content .= '</div></div>';

		return $content;
	}
        function _tw_snippet() {
            global $mashsb_options;
            !empty($mashsb_options['mashsharer_hashtag']) ? $via = 'via @' . $mashsb_options['mashsharer_hashtag'] : $via = '';
		
            if (isset($_GET['post'])) {
			$post_id = (int) $_GET['post'];
		}
		
		//global $MASHOG_OG_Output;

		$content = '<div id="wp_og_snippet" style="background-color: #fff;border: 1px solid;border-color: #e9eaed #e9eaed #d1d1d1;width:488px;padding: 10px;margin-bottom:10px;">';
		//$content .= '<div><span style="color: #333;font-weight: bold;font-size: 14px;">' . MASHOG_OG_Output::_get_title() . '</span><br />';
                $content .= '<div style="color: #292f33;font-weight: normal;font-size: 14px;">' . MASHOG()->MASHOG_OG_Output->_get_tw_title() . ' <span style="font-size: 14px;color: #66b5d2; text-decoration:none;">' . MASHOG()->MASHOG_OG_Output->_get_hashtag() . '</span> ';
		$content .= '<a href="' . get_permalink($post_id) . '" target="_blank" style="font-size: 14px;color: #66b5d2; text-decoration:none;" class="url">' . get_permalink($post_id) . '</a> '  . $via;
		$content .= '</div>';

		return $content;
	}

}