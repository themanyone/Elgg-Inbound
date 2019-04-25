<?php
/* @title Inbound Wire and Bookmarks
 * @description Share to thewire or bookmarks via URL query ?u=http://...
 * @copyright (C) 2019 Henry Kroll III www.thenerdshow.com
 * @license GPL2
 */
elgg_register_plugin_hook_handler('view', 'forms/thewire/add', 'inbound_thewire');
elgg_register_plugin_hook_handler('view', 'bookmarks/listing/all', 'inbound_bookmark');

// Be like Twitter.
// Every website should feature a "talk about this" button.
// It works just "tweet this" buttons only it goes to your Elgg site.
// The button, when clicked, posts site URL and description to the wire.
// example http://mysite.com/thewire?u=http://URL.com&text=description
function inbound_thewire($hook, $type, $vars, $params){
   if(elgg_is_logged_in()){
      $vars = preg_replace('#(>).*?(</textarea)#',
      '$1'.get_input('text').' '.get_input('u').'$2', $vars);
   }
   return $vars;
}

// Be like Facebook.
// Every website should feature a "bookmark this" button.
// It works just like "share to Facebook" only it goes to your Elgg site.
// The button, when clicked, creates a bookmark under their username.
// example http://mysite.com/bookmarks?u=http://URL.com&text=description
function inbound_bookmark($hook, $type, $vars, $params){
   $u = get_input('u');
   $text = get_input('text');
   if(elgg_is_logged_in() && strlen($u)){
      // we need user id which can't be supplied via a link button
      $id = elgg_get_logged_in_user_entity()->guid;
      echo(<<<EOF
<script>
<!--
location.replace("bookmarks/add/$id?address=$u&title=$text");
-->
</script>
EOF
);
   }
   return $vars;
}
