<?php
add_filter( 'wpseo_metabox_prio', [$this, function () {
  return 'low';
}] );
