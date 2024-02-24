<?php

add_filter( 'rest_namespace_index', 'disable_index_for_rest_api'  );
add_filter( 'rest_index', 'filter_rest_api_index_data', PHP_INT_MAX, 10, 2 );
foreach ( array( 'wp_head', 'rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head' ) as $action ) {
// Feed generator tags.
  /*
   * Removes meta tag displaying WP version.
   */
  remove_action( $action, 'the_generator' );
}

/**
 * Filters the REST API namespace index data.
 *
 * This typically is just the route data for the namespace, but you can
 * add any data you'd like here.
 *
 * @since 4.4.0
 *
 * @param WP_REST_Response $response Response data.
 * @param WP_REST_Request  $request  Request data. The namespace is passed as the 'namespace' parameter.
 */
function filter_rest_api_index_data( $response ) {
  $data               = $response->get_data();
  $data['namespaces'] = [];
  $data['routes']     = [];
  $response->set_data( $data );

  return $response;
}


/** filter: rest_index
 *  Filters the REST API root index data.
 *
 *  This contains the data describing the API. This includes information
 *  about supported authentication schemes, supported namespaces, routes
 *  available on the API, and a small amount of data about the site.
 *
 * @param WP_REST_Response $response Response data.
 * @param WP_REST_Request $request Request data.
 *
 * @return array|WP_REST_Response
 */
function filter_rest_api_root_index_data( $response, $request ) {
  if(WP_DEBUG) {
    return $response;
  }
 return array();
}

