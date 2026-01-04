<?php
// Add default posts and comments RSS feed links to <head>.
add_theme_support( 'automatic-feed-links' );
// end add default posts and comments RSS feed links to <head>.

function myFeedExcluder($query) {
 if ($query->is_feed) {
   $query->set('cat','-1554,-1551,-1552,-1553,-344,-347,-346,-345');
   $query->set('tag__not_in', array('3184,3265'));
 }
return $query;
}
add_filter('pre_get_posts','myFeedExcluder');


$url = $_SERVER["REQUEST_URI"];
$isItSpotlight = strpos($url, 'spotlight');

if ($isItSpotlight !== false) {
  function myfeed_request( $qv ) {
    if ( isset( $qv['feed'] ) && !isset( $qv['post_type'] ) ) {
      $qv['post_type'] = array( 'webinar', 'post', 'event' );
    }
    return $qv;
  }
  add_filter( 'request', 'myfeed_request' );
}
