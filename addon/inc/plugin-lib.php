<?php

function var_dump_ret($mixed = null) {
	ob_start();
	var_dump($mixed);
	$content = ob_get_clean();
	return htmlspecialchars($content, ENT_QUOTES);
}

function var_dump_pre($mixed = null) {
	echo '<pre>';
	echo var_dump_ret($mixed);
	echo '</pre>';
}

function bs4_get_shortcode_class($atts, $class = '') {
	if (is_array($atts) && array_key_exists('class', $atts) && !empty($atts['class']))
		$class = empty($class) ? $atts['class'] : $class . ' ' . $atts['class'];

	$output = '';

	if (is_array($atts) && array_key_exists('id', $atts) && !empty($atts['id']))
		$output .= ' id="' . $atts['id'] . '"';

	if (!empty($class))
		$output .= ' class="' . $class . '"';

	return $output;
}

function bs4_filter_booleans($list, $bools) {
	foreach ($list as $key => $value)
		if (in_array($key, $bools))
			$list[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
	return $list;
}

function bs4_shortcode_atts( $default_pairs, $atts, $shortcode = '') {
	if (is_array($atts)) {
		foreach($atts as $name => $value )
			if (is_numeric($name)) {
				$atts[$value] = true;
				unset($atts[$name]);
				continue;
			}
	} elseif (!empty($atts)) {
		$atts = array($atts => true);  // $atts was a string, change to array
	} else {
		$atts = array();
	}

	// fix contectual types inline;  "info" or "info='1'" becomes "type='info'"
	if (array_key_exists('type', $default_pairs) && (!array_key_exists('type', $atts))) {
		$types = array('default', 'primary', 'success', 'info', 'warning', 'danger');
		foreach ($types as $type) {
			if (isset($atts[$type]) && filter_var($atts[$type], FILTER_VALIDATE_BOOLEAN) === true) {
				$atts['type'] = $type;
				break;
			}
		}
	}

	return shortcode_atts($default_pairs, $atts, $shortcode);
}

/* --------------- in case raw-scripts.php is not included --------------- */

if (!function_exists('ts_enqueue_script')) :

	function __bs4_output_enqueued_scripts() {
		global $__bs4_enqueued_scripts;

		if (isset($__bs4_enqueued_scripts)) {
			echo '<script type="text/javascript">' . PHP_EOL;
			echo $__bs4_enqueued_scripts;
			echo '</script>' . PHP_EOL;
		}
	}

	function ts_enqueue_script($comment, $js) {
		global $__bs4_enqueued_scripts;

		if (!isset($__bs4_enqueued_scripts)) {
			$__bs4_enqueued_scripts = '';
			add_action( 'wp_footer', '__bs4_output_enqueued_scripts', 999 );
		}

		$__bs4_enqueued_scripts .= '/* ' . $comment . ' */' . PHP_EOL;
		$__bs4_enqueued_scripts .= $js . PHP_EOL;
	}

endif;
