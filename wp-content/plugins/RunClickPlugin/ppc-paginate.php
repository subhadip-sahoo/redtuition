<?php
/**
 * Set the wp-content and plugin urls/paths
 */

if (!class_exists('PPCPaginate')) {
	class PPCPaginate {
		/**
		 * @var string The options string name for this plugin
		 */
		var $optionsName = 'ppc_paginate_options';

		/**
		 * @var array $options Stores the options for this plugin
		 */
		var $options = array();

		var $type = 'posts';

		/**
		 * PHP 4 Compatible Constructor
		 */
		function PPCPaginate() {$this->__construct();}

		/**
		 * PHP 5 Constructor
		 */
		function __construct() {
			
			//Initialize the options
			$this->get_options();
		}

		/**
		 * Pagination based on options/args
		 */
		function paginate($args = false) {
			if ($this->type === 'comments' && !get_option('page_comments'))
				return;

			$r = wp_parse_args($args, $this->options);
			extract($r, EXTR_SKIP);

			if (!isset($page) && !isset($pages)) {
				global $wp_query;

				if ($this->type === 'posts') {
					$page = get_query_var('paged');
					$posts_per_page = intval(get_query_var('posts_per_page'));
					$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
				}
				else {
					$page = get_query_var('cpage');
					$comments_per_page = get_option('comments_per_page');
					$pages = get_comment_pages_count();
				}
				$page = !empty($page) ? intval($page) : 1;
			}

			$prevlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page - 1))
				: get_comments_pagenum_link($page - 1);
			$nextlink = ($this->type === 'posts')
				? esc_url(get_pagenum_link($page + 1))
				: get_comments_pagenum_link($page + 1);

			$output = ''; /* stripslashes($before); */
			if ($pages > 1) {
				$output .= sprintf('<ul>');
				$output .= sprintf('<li class="total_pages phone_hide"><span class="title">%s</span></li>', stripslashes($title.$page.' of '.$pages));
				$ellipsis = "<li class='phone_hide'><span class='gap'>...</span></li>";

				if ($page > 1 && !empty($previouspage)) {
					$output .= sprintf('<li class="phone_hide"><a href="%s" class="prev">%s</a></li>', $prevlink, stripslashes($previouspage));
				}
				if($page==1)
				{
					$output .= sprintf('<li class="disable phone_hide"><span>%s</span></li>',stripslashes($previouspage));
				}
				$min_links = $range * 2 + 1;
				$block_min = min($page - $range, $pages - $min_links);
				$block_high = max($page + $range, $min_links);
				$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
				$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

				if ($left_gap && !$right_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop(1, $anchor),
						$ellipsis,
						$this->paginate_loop($block_min, $pages, $page)
					);
				}
				else if ($left_gap && $right_gap) {
					$output .= sprintf('%s%s%s%s%s',
						$this->paginate_loop(1, $anchor),
						$ellipsis,
						$this->paginate_loop($block_min, $block_high, $page),
						$ellipsis,
						$this->paginate_loop(($pages - $anchor + 1), $pages)
					);
				}
				else if ($right_gap && !$left_gap) {
					$output .= sprintf('%s%s%s',
						$this->paginate_loop(1, $block_high, $page),
						$ellipsis,
						$this->paginate_loop(($pages - $anchor + 1), $pages)
					);
				}
				else {
					$output .= $this->paginate_loop(1, $pages, $page);
				}

				if ($page < $pages && !empty($nextpage)) {
					$output .= sprintf('<li class="phone_hide"><a href="%s" class="next">%s</a></li>', $nextlink, stripslashes($nextpage));
				}
				if($page == $pages)
				{
					$output .= sprintf('<li class="disable phone_hide"><span>%s</span></li>',stripslashes($nextpage));
				}
				
				$output .= "</ul>";
			}
			$output .= '';/* stripslashes($after); */

			if ($pages > 1 || $empty) {
				echo $output;
			}
		}

		/**
		 * Helper function for pagination which builds the page links.
		 */
		function paginate_loop($start, $max, $page = 0) {
			$output = "";
			for ($i = $start; $i <= $max; $i++) {
				$p = ($this->type === 'posts') ? esc_url(get_pagenum_link($i)) : get_comments_pagenum_link($i);
				$output .= ($page == intval($i))
					? "<li class='phone_hide active'><span>$i</span></li>"
					: "<li class='phone_hide'><a href='$p' title='$i' class='page'>$i</a></li>";
			}
			return $output;
		}

		/**
		 * Retrieves the plugin options from the database.
		 * @return array
		 */
		function get_options() {
			if (!$options = get_option($this->optionsName)) {
				$options = array(
					'title' => 'Pages:',
					'nextpage' => '&raquo;',
					'previouspage' => '&laquo;',
					'css' => true,
					'before' => '<div class="navigation">',
					'after' => '</div>',
					'empty' => true,
					'range' => 3,
					'anchor' => 1,
					'gap' => 3
				);
				update_option($this->optionsName, $options);
			}
			$this->options = $options;
		}
		
	}
}

//instantiate the class
if (class_exists('PPCPaginate')) {
	$ppc_paginate = new PPCPaginate();
}

/**
 * Pagination function to use for posts
 */
function ppc_paginate($args = false) {
	global $ppc_paginate;
	$ppc_paginate->type = 'posts';
	return $ppc_paginate->paginate($args);
}

/**
 * Pagination function to use for post comments
 */
function ppc_paginate_comments($args = false) {
	global $ppc_paginate;
	$ppc_paginate->type = 'comments';
	return $ppc_paginate->paginate($args);
}

?>