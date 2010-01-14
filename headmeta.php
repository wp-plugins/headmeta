<?php
/*
Plugin Name: HeadMeta
Plugin URI: http://dougal.gunters.org/plugins/headmeta
Demo URI: http://dougal.gunters.org/blog/2004/06/17/my-first-wordpress-plugin-headmeta
Description: This plugin allows you to add &lt;meta&gt; and &lt;link&gt; tags to the &lt;head&gt; of your posts or pages based on post custom fields. Use keys named "head_meta" and "head_link". Also, if you have a custom field named "keyword" or "keywords", it will automatically generate a standard &lt;meta name="keywords" content="whatever" /&gt; tag, which some search engines will use for indexing. Likewise for a key of 'description' generating a standard description meta tag.
Author: Dougal Campbell
Author URI: http://dougal.gunters.org/
Version: 1.5

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
	if (! is_array($metavals)) {
		$metavals = (array) $metavals;
	}
	$linkvals = get_post_meta($id, 'head_link', false);
	if (! is_array($linkvals)) {
		$linkvals = (array) $linkvals;
	}

	// A key of either 'keyword' or 'keywords' will generate a 
	// standard 'keywords' meta tag. Both variants are used for
	// compatibility with other plugins, such as Related Posts.
	$keyword = get_post_meta($id, 'keyword', false);
	$keywords = get_post_meta($id, 'keywords', false);
	
	// This will turn each into a (possibly empty) string:
	if (is_array($keyword)) {
		$keyword = implode(',', $keyword);
	}

	if (is_array($keywords)) {
		$keywords = implode(',', $keywords);
	}
	
	if (! (empty($keyword) || empty($keywords))) {
		// both populated, combine with a comma:
		$keys = $keyword . ', ' . $keywords;
	} else if (! empty($keyword)) {
		// only 'keyword' populated
		$keys = $keyword;
	} else if (! empty($keywords)) {
		// only 'keywords' populated
		$keys = $keywords;
	}
	
	// Generate the tags
	if (count($metavals)) {
		foreach ($metavals as $meta) {
			if (! empty($meta)) {
				$tag = "<meta $meta />";
				print "$tag\n";
			}
		}
	}
	
	if (count($linkvals)) {
		foreach ($linkvals as $link) {
			if (! empty($link)) {
				$tag = "<link $link />";
				print "$tag\n";
			}
		}
	}
	
	// Output the keywords meta tag if we have keywords
	if (! empty($keys)) {
		$keys = wp_specialchars($keys);
		$tag = "<meta name='keywords' content='$keys' />";
		print "$tag\n";
	}

	// Shortcut for description meta tag:
	$description = get_post_meta($id, 'description', false);
	
	// If it's an array, implode it into a string
	if (is_array($description)) {
		$description = implode('; ', $description);
	}
	
	if (! empty($description)) {
		$description = wp_specialchars($description);
		$tag = "<meta name='description' content='$description' />";
		print "$tag\n";
	}

}

// Hook into the Plugin API
add_action('wp_head', 'headmeta');

?>