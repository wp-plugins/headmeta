=== HeadMeta ===
Contributors: dougal
Donate link: http://dougal.gunters.org/donate
Tags: seo, meta, keywords, posts, search, google, description, links, link, headmeta, metadata, pages
Requires at least: 1.2
Tested up to: 4.3
Stable tag: 1.5

Automatically add &lt;link>, &lt;meta> description and &lt;meta> keywords to your
HTML on a per-post (or page) basis.

== Description ==

HeadMeta creates `<meta>` "description" or "keywords" tags for individual
posts or pages. It can also create arbitrary `<meta>` or `<link>` tags.
These are easily set on a per-post (or page) basis by simply adding Custom
Fields.

See the Installation section for more detailed examples.

== Installation ==

1. Upload the `headmeta` folder and its contents to your `wp-contents/plugins` directory.
2. Activate in the `Plugins` menu.
3. Add Custom Fields to your posts.

To use this plugin, you add key/value pairs in the Custom Fields section
when you create or edit a post or page. If you enter `description` or 
`keywords` as the name of the key, HeadMeta will automatically generate an
appropriate `<meta>` "description" or "keywords" tag in the head of your
HTML.

If you need to create arbitrary `<link>` or `<meta>` tags, you can use
"`head_link`" and "`head_meta`" as the key. Whatever you enter as the value for
that custom field will be plugged into the generated `<link>` or `<meta>` tag.
For example, if you added the following keys and values:

  **KEY**: `head_link`
  **VALUE**: `rel="seealso" href="http://example.com/movies/"`

  **KEY**: `head_meta`
  **VALUE**: `name="keywords" content="entertainment,movies"`

This would generate two tags in the <head> of the page when someone visited
the permalink for the post:

 `<link rel="seealso" href="http://example.com/movies/" />`
 `<meta name="keywords" content="entertainment,movies" />`

== Changelog ==
= 1.5 2010-01-14 =
* Tested up to WordPress 3.0-alpha

