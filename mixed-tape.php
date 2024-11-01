<?php
/*
Plugin Name: WP Mixed Tape
Plugin URI: http://www.dean-logan.com/blog/plugins-and-widgets/wp-mixed-tape
Description: Creates a mixed tape play list on a post or page
Version: 1.1.0
Author: Dean Logan
Author URI: http://www.dean-logan.com
*/
/**  Copyright 2006-2009  Dean Logan  (email : wp-dev@dean-logan.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

To view a copy of the GNU General Public License
go to <http://www.gnu.org/licenses/>.
**/

/**
* Guess the wp-content and plugin urls/paths
*/
if ( !defined('WP_CONTENT_URL') )
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

if (!defined('PLUGIN_URL'))
    define('PLUGIN_URL', WP_CONTENT_URL . '/plugins/');
if (!defined('PLUGIN_PATH'))
    define('PLUGIN_PATH', WP_CONTENT_DIR . '/plugins/');

if (!class_exists('MixedTape')) {
	class MixedTape
	{				
			//-------------------------------------------------------------------------------------
			// Options:
			var $REL_ATTR = 'bookmark nofollow';
			var $BCOMPAT_ANCHORS = 'on';
		
			var $DEF_TITLE = /*'&nabla; '.*/'My Awesome Mixed Tape';
			var $DEF_CLASS = '';
			var $DEV_TYPE = 'MIXEDTAPE';
			var $DEF_ICON = 'TAPE';
			var $DEF_STYLE = '';
			var $DEF_SONGURL = '';
			var $DEF_COVERURL = '';
			var $DEF_ARTIST = '';
			var $DEF_ALTTEXT = '';
		
			//-------------------------------------------------------------------------------------
			// State & instance variables:
			var $fullplaylist = array();
			var $playListID = 0;	
			//-------------------------------------------------------------------------------------
			
			/*
			* Short code for creating playlist 
			*/
			function doMixedTapeShortcode($atts, $content = null) {
				$this->shortcodeWasHere = true;
				$playlistDisplay = '';
				if (!$this->fullplaylist) return '';
				
				extract(shortcode_atts(array(
					'title' => $this->DEF_TITLE,
					'class' => $this->DEF_CLASS,
					'style' => $this->DEF_STYLE,
					'type' => $this->DEV_TYPE,
					'artist' => $this->DEF_ARTIST,
					'icon' => $this->DEF_ICON,
					'cover' => $this->DEF_COVERURL,
					), $atts ));
				
				
				$rel = $this->REL_ATTR;
				$toc = '';
				
				foreach ($this->fullplaylist as $each) {
					//-- To handle anchors in headings, either
					// Create link to MusicBrainz with search parameter of artist
					switch($type){
						case 'SINGLEALBUM':
							$toc .= '<li>' . $each['title'] . '</li>';
							
							break;
						case 'MIXEDTAPE':
						default:
							$toc .= '<li>' . $each['title'] . ' &nbsp;&nbsp;<br />by ' . getMusicBrainz($each['artist']) . '</li>';
							break;
					}
				}
				
				if (!$class){
					$class = "mixedTapePlayList";
				}
				if ($style) $style = ' style="' . $style . '"';
				
				switch($icon){
					case 'CD':
						$headerImage = '<img class="playlist-img" src="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/mixedtape_cd.png" align="right" />';
						break;
					case 'CDCASE':
						$headerImage = '<img class="playlist-img" src="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/mixedtape_cdcase.png" align="right" />';
						break;	
					case 'HEADPHONES':
						$headerImage = '<img class="playlist-img" src="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/mixedtape_headphones.png" align="right" />';
						break;	
					case 'ALBUMCOVER':
						$headerImage = '<img class="playlist-img" src="' . $cover . '" align="right" />';
						break;
					case 'TAPE':
					default:
						$headerImage = '<img class="playlist-img" src="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/mixedtape_ani_60.gif" align="right" />';		
						break;
				}
				
				$tochdr = '<strong class="playlist-header">' . $headerImage . $title .'</strong>';
				
				$playlistDisplay = '<div id="playListBox" class="' . $class . '"' . $style. '>';
				$playlistDisplay .= $tochdr;
				$playlistDisplay .= '<ol>' . $toc . '</ol>';
				if($type == 'SINGLEALBUM' && $artist != ''){
					 $playlistDisplay .= '&nbsp;&nbsp;Find more music by ' . getMusicBrainz($artist);
				}
				$playlistDisplay .= '</div>';	
					
				return $playlistDisplay;
			}
			/*
			* Short code for track players 
			*/
			function doTrackShortcode($atts) {
				$this->shortcodeWasHere = true;
				extract(shortcode_atts(array(
					'title' => $this->DEF_TITLE,
					'artist' => $this->DEF_ARTIST,
					'url' => $this->DEF_SONGURL,
					'alt' => $this->DEF_ALTTEXT,
					), $atts ));
					
				$playListID = ++$this->playListID;	
				$this->fullplaylist[$playListID] = array('title'=>$title, 'artist'=>$artist);
				
				/* player version 2 code, that doesn't really work
				$playerCode = '<strong id="audioplayer_' . $playListID . '">';
				if($alt == ''){
					$playerCode .= $title . '</strong>';
				} else {
					$playerCode .= $alt . '</strong>';
				}
				$playerCode .= '<script type="text/javascript"> ';
				$playerCode .= 'AudioPlayer.embed("audioplayer_' . $playListID . '", {soundFile: "' . $url . '"});  ';
				$playerCode .= '</script>  ';
				*/
				
				$playerCode = '<object type="application/x-shockwave-flash" data="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/audio/player.swf" id="audioplayer' . $playListID . '" height="20" width="80">';
				$playerCode .= '<param name="movie" value="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/audio/player.swf">';
				$playerCode .= '<param name="FlashVars" value="playerID=' . $playListID . '&amp;soundFile=' . $url . '&amp;animation=no&amp;">';
				$playerCode .= '<param name="quality" value="high">';
				$playerCode .= '<param name="menu" value="false">';
				$playerCode .= '<param name="wmode" value="transparent">';
				$playerCode .= '</object>';		
				
				return $playerCode;
			}
			
			/*
			* Function for adding JavaScript link to header
			* and for adding CSS file to header
			*/
			function mixedtape_playerconfig() {
				if(!is_admin())
				{
					echo '<link type="text/css" rel="stylesheet" href="' . PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/mixed-tape.css" />' . "\n";
					wp_enqueue_script('mixedtape_player_script', PLUGIN_URL . dirname(plugin_basename(__FILE__)) . '/audio/audio-player.js');
				}
			}
			
			//Class Functions
			/**
			* PHP 4 Compatible Constructor
			*/
			function MixedTape(){$this->__construct();}
			
			/**
			* PHP 5 Constructor
			*/        
			function __construct(){
				//Language Setup
				$locale = get_locale();
				$mo = dirname(__FILE__) . "/languages/" . $this->localizationName . "-".$locale.".mo";
				load_textdomain($this->localizationDomain, $mo);
	
				//"Constants" setup
				$thispluginurl = PLUGIN_URL . dirname(plugin_basename(__FILE__)). '/';
				$thispluginpath = PLUGIN_PATH . dirname(plugin_basename(__FILE__)). '/';
				
				if(!is_admin())
				{
					add_action('wp_print_scripts', array(&$this, 'mixedtape_playerconfig'));
					add_shortcode('track', array(&$this, 'doTrackShortcode'));
					add_action('the_content', array(&$this, 'mixedtape_shortcode'), 11);
				}
			}

		
		// Function to add the playlist short code after the content is loaded.
		function mixedtape_shortcode($content) {
		   add_shortcode('mixedtape', array(&$this, 'doMixedTapeShortcode'));
		   return do_shortcode($content);
		}		
	}
}

/*
* Function for creating Music Brainz URL
*/
function getMusicBrainz($artistName){
	$titleAltText = 'Find the artist ' . $artistName . ' on MusicBrainz';
	
	$musicBrainz = '<a class="musicbrainz" href="http://musicbrainz.org/search/textsearch.html?query=';
	$musicBrainz .= $artistName . '&type=artist&limit=25&handlearguments=1"';
	$musicBrainz .= ' alt="' . $titleAltText . '" title="' . $titleAltText . '"';
	$musicBrainz .= ' target="_blank">' . $artistName . '</a>';
	
	return $musicBrainz;
}
			
//---------------------------------------------------------------------------------------------
//instantiate the class
if (class_exists('MixedTape')) {
    $MixedTape_var = new MixedTape();
}

?>
