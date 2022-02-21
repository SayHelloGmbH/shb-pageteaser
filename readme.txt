=== Block: Page Teaser ===
Contributors:      markhowellsmead
Tags:              block, teaser
Tested up to:      5.9
Stable tag:        1.0.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Display a preview teaser for a selected sub-page.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/shb-pageteaser` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Add a “page teaser” block to the required place in the editor and select a page.

== Developer notes ==

=== Modifying response ===

The following filters are available for developers' use.

==== Base CSS class name for the block

`apply_filters('shb-pageteaser/classnamebase', string $classNameBase, WP_Block $block);`

==== Block content HTML ====

`apply_filters('shb-pageteaser/html', string $html, WP_Block $block);`

==== Image HTML ====

`apply_filters('shb-pageteaser/image', string $image, string $post_id, WP_Block $block);

== Changelog ==

= 1.0.0 =
* Release
