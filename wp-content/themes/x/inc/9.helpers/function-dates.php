<?php
/**
 * Get the HTML markup for the posted date of a post.
 *
 * The method returns the HTML markup for the posted date of a post,
 * including the date string formatted as "j.n.Y" (day.month.year).
 *
 * @return string The HTML markup for the posted date.
 */
function x_get_posted_on() {

  $time_string_format = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  $time_string = sprintf($time_string_format, esc_attr(get_the_date('j.n.Y')), esc_html(get_the_date()));
  return '<span class="posted-on">' . $time_string . '</span>';

}
