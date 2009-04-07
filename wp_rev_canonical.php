<?php
/*
Plugin Name: WP RevCanonical
Plugin URI: http://www.nixonmcinnes.co.uk/
Description: Implements the <a href="http://revcanonical.appspot.com/">RevCanonical spec</a> in order to solve the <a href="http://www.scripting.com/stories/2009/03/07/solvingTheTinyurlCentraliz.html">TinyURL centralization problem</a>.
Author: Steve Winton
Version: 0.1
Author URI: http://www.nixonmcinnes.co.uk/people/steve
*/

function rev_canonical_hints() {
    global $post;
    
    if (is_single()) {
        $href = rtrim(get_bloginfo('url'), '/') . '/?p=' . $post->ID;
        printf('
            <link rev="canonical" href="%s" />
            <link rel="alternate shorter" href="%s" />%s',
            $href, $href, "\n"
        );
    }
}

add_action('wp_head', 'rev_canonical_hints');
?>