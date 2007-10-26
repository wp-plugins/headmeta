<?php
/*
Plugin Name: HeadMeta
Plugin URI: http://dougal.gunters.org/blog/2004/06/17/my-first-wordpress-plugin-headmeta
Description: This plugin allows you to add <meta> and <link> tags to the <head> of your posts or pages based on post custom fields. Use keys named "head_meta" and "head_link". Also, if you have a custom field named "keyword" or "keywords", it will automatically generate a standard <meta name="keywords" content="whatever" /> tag, which some search engines will use for indexing.
Author: Dougal Campbell
Author URI: http://dougal.gunters.org/
Version: 1.3

TODO:
 * Add a config page
 * Add support for tags as keywords

You can add custom fields named "head_meta" and "head_link", which will
be converted into <meta> and <link> tags.

Examples:

  key: head_meta
  val: name='keywords' content='foo,bar,baz'

  result: <meta name='keywords' content='foo,bar,baz' />


  key: head_link
  val: rel='seealso' href='http://example.com/morestuff.html'

  result: <link rel='seealso' href='http://example.com/morestuff.html' />


  // shorthand for "keywords" meta tag
  key: keyword
  val: dogs, canines, pets, training

  result: <meta name='keywords' content='dogs, canines, pets, training' />

*/ 

function headmeta() {
	global $posts;

	// only act when viewing a single post or a page. Else, exit.
	if ( !(is_single() || is_page() ) ) return;
	
	// Get the post
	$post = $posts[0];
	
	// Get the keys and values of the custom fields:
	$id = $post->ID;
	$metavals = get_post_meta($id, 'head_meta', false);
	$linkvals = get_post_meta($id, 'head_link', false);

	// A key of either 'keyword' or 'keywords' will generate a 
	// standard 'keywords' meta tag. Both variants are used for
	// compatibility with other plugins, such as Related Posts
	$keywords = array_merge((array) get_post_meta($id, 'keyword', false), (array) get_post_meta($id, 'keywords', false));
	// Generate the tags
	if (count($metavals)) {
		foreach ($metavals as $meta) {
			$tag = "<meta $meta />";
			print "$tag\n";
		}
	}
	
	if (count($linkvals)) {
		foreach ($linkvals as $link) {
			$tag = "<link $link />";
			print "$tag\n";
		}
	}
	
	if (count($keywords)) {
		$keys = implode(',',$keywords); // stitch multiples together
		$keys = wp_specialchars($keys);
		$tag = "<meta name='keywords' content='$keys' />";
		print "$tag\n";
	}

}

// Hook into the Plugin API
add_action('wp_head', 'headmeta');

?>