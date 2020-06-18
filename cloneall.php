<?php
set_time_limit( 0 );

use Milo\Github\Api;
use Milo\Github\Paginator;

require __DIR__ . '/vendor/autoload.php';

$token  = '{your-token-here}';
$gh_api = new Api();
$gh_api->setToken( new \Milo\Github\OAuth\Token( $token ) );


if ( file_exists( __DIR__ . '/repos.json' ) ) {
	$data = json_decode( file_get_contents( __DIR__ . '/repos.json' ) );
}

if ( empty( $data ) ) {
	$request    = $gh_api->createRequest( 'GET', '/user/repos/' );
	$final_data = array();
	$paginator  = new Paginator( $gh_api, $request );
	foreach ( $paginator->limit( 100 ) as $page => $response ) {
		$final_data = array_merge( $final_data, $gh_api->decode( $response ) );
	}
	file_put_contents( __DIR__ . '/repos.json', json_encode( $final_data ) );
	$data = $final_data;
}


echo PHP_EOL . 'Total Repo : ' . count( $data ) . PHP_EOL . PHP_EOL;

array_map( function ( $repo ) {
	if ( ! file_exists( __DIR__ . '/' . $repo->full_name ) ) {
		echo '=====================================================================' . PHP_EOL;
		exec( 'git clone ' . $repo->clone_url . ' ' . __DIR__ . '/' . $repo->full_name );
		echo '=====================================================================' . PHP_EOL . PHP_EOL;
	}
	return $repo;
}, $data );
