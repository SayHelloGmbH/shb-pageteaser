<?php

/**
 * Plugin Name:       Block: Page teaser
 * Description:       Display a preview teaser for a selected sub-page.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           1.0.1
 * Author:            Say Hello GmbH
 * Author URI:        https://sayhello.ch/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       shb-pageteaser
 * Domain Path:       /languages
 */

function shb_pageteaser_block_init()
{
	register_block_type(__DIR__ . '/build', [
		'render_callback' => 'render_block_shb_pageteaser',
		'attributes' => [
			'post' => [
				'type' => 'string',
				'default' => ''
			],
			'imageSize' => [
				'type' => 'string',
				'default' => 'medium'
			]
		]
	]);
}
add_action('init', 'shb_pageteaser_block_init');

function render_block_shb_pageteaser(array $attributes, string $content, WP_Block $block)
{

	$blockWrapperAttributes = get_block_wrapper_attributes();
	preg_match_all('/class="(.*?)"/s', $blockWrapperAttributes, $match);
	$classNameBase = $match[1][0] ?? 'UNDEFINED_CLASS_NAME_BASE';

	// Allow modification via filter
	$classNameBase = apply_filters('shb-pageteaser/classnamebase', $classNameBase, $block);

	if (!(int) ($attributes['post'] ?? 0)) {
		return sprintf('<div class="c-editormessage c-editormessage--error"><p>%s</p></div>', __('Please select a page', 'shb-pageteaser'));
	}

	$post = get_post($attributes['post']);
	if (!$post instanceof WP_Post) {
		return sprintf('<div class="c-editormessage c-editormessage--error"><p>%s</p></div>', __('The selected entry is not a page.', 'shb-pageteaser'));
	}

	$image = sprintf('<figure class="%s"></figure>', "{$classNameBase}__figure {$classNameBase}__figure--empty");

	if (has_post_thumbnail($post->ID)) {
		$image = sprintf('<figure class="%s"><a class="%s" href="%s">%s</a></figure>', "{$classNameBase}__figure", "{$classNameBase}__figurelink", get_permalink($post->ID), wp_get_attachment_image(get_post_thumbnail_id($post->ID), $attributes['imageSize']), false, ['class' => "{$classNameBase}__image"]);
	}

	// Allow modification via filter
	$image = apply_filters('shb-pageteaser/image', $image, $post->ID, $block);

	ob_start();

?>
	<article <?php echo $blockWrapperAttributes; ?>>

		<?php echo $image; ?>

		<header class="<?php echo "{$classNameBase}__header"; ?>">
			<h3 class="<?php echo "{$classNameBase}__title"; ?>"><a class="<?php echo "{$classNameBase}__titlelink"; ?>" href="<?php the_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h3>
		</header>

		<?php if (!empty($excerpt = get_the_excerpt($post->ID))) { ?>
			<div class="<?php echo "{$classNameBase}__excerpt"; ?>"><?php echo $excerpt; ?></div>
		<?php }
		?>

		<footer class="<?php echo "{$classNameBase}__footer"; ?>">
			<a class="<?php echo "{$classNameBase}__footerlink"; ?>" href="<?php the_permalink($post->ID); ?>"><?php _e('Read more', 'shb-pageteaser'); ?></a>
		</footer>
	</article>
<?php
	$html = ob_get_contents();

	// Allow modification via filter
	$html = apply_filters('shb-pageteaser/html', $html, $block);

	ob_end_clean();
	return $html;
}
