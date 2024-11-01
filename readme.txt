=== WP Mixed Tape===
Contributors: Dean Logan
Donate link: http://www.dean-logan.com/plugins-and-widgets
Tags: mixed tape, audio player, mp3, MusicBrainz
Requires at least: 2.7.1
Tested up to: 2.8.4
Stable tag: 1.1.2

This a plugin that will make a 'Mixed Tape' post from mp3 file and play list shortcode.

== Description ==
This a plugin that will take shortcode for track listings and make a 'Mixed Tape' or 'Mix Tape' by turning the mp3 file links into music players and creating a play list of the tracks. The play list is a second shortcode that can be placed anywhere in the post. 
The play list can also show the tracks as a single album by changing the type.  This will only show one link to the artist name added to the play list.
The play list icon can be changed to show the mixed tape, cd, cd box, head phones or any image.  The image should be small enough to fit inside the play list.

There are no admin options for the plugin.

Usage information can be found on the <a href="http://wordpress.org/extend/plugins/wp-mixted-tape/faq/">FAQ page</a> and there are examples on the <a href="http://www.dean-logan.com/blog/plugins-and-widgets/wp-mixed-tape/wp-mixed-tape-test-page">Mixed Tape Test page</a>.

The plugin uses <a href="http://www.1pixelout.net">1PixelOut</a>'s standalone <a href="http://wpaudioplayer.com/">WordPress MP3 player</a>, but should not conflict with other plugins using the player.

The plugin creates a search link to <a href="http://musicbrainz.org">MusicBrainz</a> music database for the artist of the track.

== Installation ==
1. Upload `wp-mixed-tape` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
= What music files does it play? =
Currently the track player only allows for MP3 files.

= Where should I put the music files? =
The track player uses the full url of the music file. If you haven't created a folder for your audio, create a "audio" folder directly under the blog root and refrence the files from that location.

= Can I alter the style of the play list? =
Yes. There is a style sheet under the plugin directory.  In the future you will be able to enter style and class information for each playlist.

= Can I alter the style of the track player? =
No.  In order for the track to fit in the post text, I reduced the size and look of the player.

= How do I add a track? =
The track short code is [ track title="{track title}" artist="{track artist}" url="{track url}" alt="{alt text}" ]

* **track title** is the title for the song. This does not change what is displayed in the mp3 player as the title information is taken from the mp3 file.
* **track artist** is the artist for the song. This does not change what is displayed in the mp3 player as the title information is taken from the mp3 file.
* **track url** is the full url for the song.
* **alt text** is the alternate text shown if the player is not displayed. If left empty, it will show the track title.

= How many tracks can I put on the post? =
As many as you want.  However, a good Mixed Tape is only about 10 tracks.

= How do I add the play list? = 
The play list is created from the mixedtape short tag.  You can place it anywhere in the post, but the best place to place it is at the top.  The mixedtape shortcode is [ mixedtape title="{mixed tape title}" style="{override styles}" class="{override class}" type="{play list type}" icon="{override icon}" cover="{image url}" artist="{single album artist name}" ]

* **mixed tape title** is the title for the mixed tape to be shown at the top of the play list
* **override styles** is any extra style attributes to add to the overall play list.
* **override class** is class name given to override play list for class style.
* **play list type** is the type of play list either MIXEDTAPE or SINGLEALBUM.  MIXEDTAPE is the default and will list each artist with the song.
* **override icon** is the option to change the icon, choices are TAPE, CD, CDBOX, HEADPHONES.
* **image url** is the url for a custom image to override the icon, ALBUMCOVER must be used as the icon value.
* **single album artist name** is the name of the artist for the SINGLEALBUM type. It is ingored on the MIXEDTAPE or default type.

= What is the difference between the types of play lists? =

* The MIXEDTAPE play list is the default type.  It will show each track and the artist, with a link to search on more songs by the artist.
* The SINGLEALBUM play list will show each track and then at the end show the artist name and a link to search for more songs by the artist.

= How do I change the play list icon? =

* The `icon` value can be changed to show different icons, the options are TAPE, CD, CDBOX, HEADPHONES, ALBUMCOVER.

= Can I use my own play list icon or image? =

* Yes. Set the `icon` value to ALBUMCOVER and then the `cover` value to the url of your image.  You should use an image that is around 60px X 60px.

= What is the image next to the artist name? = 
I added a link on the play list to the MusicBrainz (http://musicbrainz.org/) site that will pull up search results for the artist name.  I figured that those listening to the Mixed Tape might want to hear other songs from the artist selected.  I also figured it would help out a OpenSource project by sending more people to the site to search for music.

= Can I remove the link to MusicBrainz? =
The image for the link is part of the style sheet file.  You could remove the style sheet class and the image will go away.

== Screenshots ==
1. Mixed Tape in post
2. Adding Mixed Tape shortcode to post
3. Adding Track shortcode to post

You can view <a href="http://www.dean-logan.com/blog/plugins-and-widgets/wp-mixed-tape/wp-mixed-tape-test-page">the sample page</a>.

== ChangeLog ==
**Version 1.1.2**

* Verified that is works on the latest WP version.

**Version 1.1.1**

* Didn't have the SVN directory properly setup.  The audio files were missing.

**Version 1.1.0**

* Added the ability to change play list `type`  (MIXEDTAPE, SINGLEABLUM)
* Single album type allows for `artist` value to be added to play list, ignored for mixed tape type
* Added the ability to change the play list `icon` (TAPE, CD, CDCASE, HEADPHONES, ALBUMCOVER)
* Added the ability to add change the icon to an defined url image with the `cover` option


**Version 1.0.0**

* Inital release.