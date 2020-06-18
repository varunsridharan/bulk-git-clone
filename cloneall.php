<?php
set_time_limit( 0 );

use Milo\Github\Api;
use Milo\Github\Paginator;

require __DIR__ . '/vendor/autoload.php';

$token  = '{your-token-here}';
$gh_api = new Api();
$gh_api->setToken( new \Milo\Github\OAuth\Token( $token ) );
$storage_dir = ( isset( $argv[1] ) ) ? trim( $argv[1], '/' ) : __DIR__;

if ( file_exists( __DIR__ . '/repos.json' ) ) {
	echo 'Repo Local Cache Found' . PHP_EOL;
	$data = json_decode( file_get_contents( __DIR__ . '/repos.json' ) );
}

if ( empty( $data ) ) {
	echo 'Repo Local Cache Empty' . PHP_EOL;
	$request    = $gh_api->createRequest( 'GET', '/user/repos/' );
	$final_data = array();
	$paginator  = new Paginator( $gh_api, $request );
	echo 'Fetching From Github.com' . PHP_EOL;
	foreach ( $paginator->limit( 100 ) as $page => $response ) {
		$final_data = array_merge( $final_data, $gh_api->decode( $response ) );
	}
	file_put_contents( __DIR__ . '/repos.json', json_encode( $final_data ) );
	$data = $final_data;
}


echo PHP_EOL . 'Total Repo Found : ' . count( $data ) . PHP_EOL . PHP_EOL;

array_map( function ( $repo ) {
	global $storage_dir;
	if ( ! file_exists( $storage_dir . '/' . $repo->full_name ) ) {
		echo '=====================================================================' . PHP_EOL;
		exec( 'git clone ' . $repo->clone_url . ' ' . $storage_dir . '/' . $repo->full_name );
		echo '=====================================================================' . PHP_EOL . PHP_EOL;
	}
	return $repo;
}, $data );
