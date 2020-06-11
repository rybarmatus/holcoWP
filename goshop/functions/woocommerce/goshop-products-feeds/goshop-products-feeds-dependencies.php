<?php

if ( ! class_exists( 'GOSHOP_HEUREKA_GENERATE_FEED' ) ) {
	require_once __DIR__ . '/classes/heureka-generate-feed.php';
}
if ( ! class_exists( 'GOSHOP_FACEBOOK_GENERATE_FEED' ) ) {
	require_once __DIR__ . '/classes/facebook-generate-feed.php';
}
if ( ! class_exists( 'GOSHOP_GOOGLE_GENERATE_FEED' ) ) {
	require_once __DIR__ . '/classes/google-generate-feed.php';
}
if ( ! class_exists( 'GOSHOP_CUSTOM_GENERATE_FEED' ) ) {
	require_once __DIR__ . '/classes/custom-generate-feed.php';
}
if ( ! class_exists( 'GOSHOP_DSA_GENERATE_FEED' ) ) {
	require_once __DIR__ . '/classes/dsa-generate-feed.php';
}
if ( ! class_exists( 'GOSHOP_PRODUCTS_GENERATE_LOOP' ) ) {
	require_once __DIR__ . '/classes/goshop-products-generate-loop.php';
}
if ( ! class_exists( 'GoshopPluginsAdmin' ) ) {
	require_once __DIR__ . '/admin/goshop-plugins-admin.php';
}
if ( ! class_exists( 'GOSHOP_FEED_ADMIN_PROCESS' ) ) {
	require_once __DIR__ . '/admin/goshop-feed-admin-process.php';
}

