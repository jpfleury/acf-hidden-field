<?php

namespace AcfHiddenField;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Registers the ACF field type.
 */
add_action('init', function () {
	if (!function_exists('acf_register_field_type')) {
		return;
	}

	require_once __DIR__ . '/class-acf-field-hidden.php';

	acf_register_field_type(__NAMESPACE__ . '\\acf_field_hidden');
});

add_action('acf/init', function () {
	add_filter('acf/prepare_field/type=hidden', function ($field) {
		$show_as_text_in_admin = !empty($field['show_as_text_in_admin']);

		if (!is_admin() || !$show_as_text_in_admin) {
			$field['wrapper']['style'] = 'display: none;';
		}

		return $field;
	});
});

add_action('acf/init', function () {
	add_filter('acf/prepare_field/type=hidden', function ($field) {
		$show_as_text_in_admin = !empty($field['show_as_text_in_admin']);

		if (is_admin() && $show_as_text_in_admin) {
			$field['label'] .= ' (<code>type="hidden"</code>)';
		} else {
			$field['label'] = '';
			$field['instructions'] = '';
		}

		return $field;
	});
});
