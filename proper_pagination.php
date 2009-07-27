<?php
/*
Plugin Name: Proper Pagination
Plugin URI: http://www.nixonmcinnes.co.uk/
Plugin Description: Renders proper pagination for a listings page
Version: 1.0
Author: NixonMcInnes
Author URI: http://www.nixonmcinnes.co.uk/people/steve/
*/

class ProperPagination {
    
    var $posts_per_page = null;
    var $found_posts = null;
    var $page = null;
    var $max_pages = null;
    var $max_page_links = null;
    var $start;
    var $end;
    var $current_page = 0;
    
    function install() {
        add_option('pp_max_pagelinks', '10');
    }
    
    function init() {
        global $wp, $wp_query;
        
        $this->posts_per_page = (int)get_option('posts_per_page');
        $this->found_posts = (int)$wp_query->found_posts;
        $this->page = isset($wp->query_vars['paged']) ? max(1, intval($wp->query_vars['paged'])) : 1;
        $this->max_pages = ceil($this->found_posts / $this->posts_per_page);
        $this->max_page_links = (int)get_option('pp_max_pagelinks');
        
        $this->start = max(1, $this->page - ceil($this->max_page_links / 2));
        $this->end = $this->start + $this->max_page_links - 1;
        
        $this->current_page = $this->start - 1;
    }
    
    function has_pagination() {
        return ($this->found_posts > $this->posts_per_page && (($this->current_page + 1) >= $this->start && $this->current_page < $this->end));
    }
    
    function the_pagination() {
        $this->current_page++;
    }
    
    function rewind_pagination() {
        $this->current_page = $this->start - 1;
    }
    
    function is_current_page() {
        return $this->current_page == $this->page;
    }
    
    function has_previous_page() {
        return $this->page > 1;
    }
    
    function has_next_page() {
        return $this->page < $this->max_pages;
    }
    
    function the_page_permalink() {
        echo get_pagenum_link($this->current_page);
    }
    
    function the_previous_page_permalink() {
        if ($this->has_previous_page()) {
            echo get_pagenum_link($this->page - 1);
        }
    }
    
    function the_next_page_permalink() {
        if ($this->has_next_page()) {
            echo get_pagenum_link($this->page + 1);
        }
    }
    
    function the_first_page_permalink() {
        echo get_pagenum_link(1);
    }
    
    function the_last_page_permalink() {
        echo get_pagenum_link($this->max_pages);
    }
    
    function the_page_num() {
        echo $this->current_page;
    }
}

global $pp;
if (is_null($pp)) {
    $pp = new ProperPagination();
    
    if (!function_exists('pp_has_pagination')) {
        function pp_has_pagination() {
            global $pp;
            
            return $pp->has_pagination();
        }
    }

    if (!function_exists('pp_the_pagination')) {
        function pp_the_pagination() {
            global $pp;
            
            return $pp->the_pagination();
        }
    }

    if (!function_exists('pp_rewind_pagination')) {
        function pp_rewind_pagination() {
            global $pp;
            
            return $pp->rewind_pagination();
        }
    }

    if (!function_exists('pp_is_current_page')) {
        function pp_is_current_page() {
            global $pp;
            
            return $pp->is_current_page();
        }
    }

    if (!function_exists('pp_has_previous_page')) {
        function pp_has_previous_page() {
            global $pp;
            
            return $pp->has_previous_page();
        }
    }

    if (!function_exists('pp_has_next_page')) {
        function pp_has_next_page() {
            global $pp;
            
            return $pp->has_next_page();
        }
    }

    if (!function_exists('pp_the_page_permalink')) {
        function pp_the_page_permalink() {
            global $pp;
            
            return $pp->the_page_permalink();
        }
    }

    if (!function_exists('pp_the_previous_page_permalink')) {
        function pp_the_previous_page_permalink() {
            global $pp;
            
            return $pp->the_previous_page_permalink();
        }
    }

    if (!function_exists('pp_the_next_page_permalink')) {
        function pp_the_next_page_permalink() {
            global $pp;
            
            return $pp->the_next_page_permalink();
        }
    }

    if (!function_exists('pp_the_first_page_permalink')) {
        function pp_the_first_page_permalink() {
            global $pp;
            
            return $pp->the_first_page_permalink();
        }
    }

    if (!function_exists('pp_the_last_page_permalink')) {
        function pp_the_last_page_permalink() {
            global $pp;
            
            return $pp->the_last_page_permalink();
        }
    }

    if (!function_exists('pp_the_page_num')) {
        function pp_the_page_num() {
            global $pp;
            
            return $pp->the_page_num();
        }
    }

    add_action('wp', array(&$pp, 'init'));
}

register_activation_hook(__FILE__, array('ProperPagination', 'install'));
?>