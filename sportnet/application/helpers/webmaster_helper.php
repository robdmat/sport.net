<?php

/**
 * Webmaster helpers to get the data related to the site 
 * Product views, coments likes etc
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * Active menu Class
 * @return string
 */
if (!function_exists('navigation_user_sidebar')) {

    function navigation_user_sidebar() {
        $CI = &get_instance();
        $segment = $CI->uri->segment(2);
        switch ($segment) {
            case 'profile':
                $menu = array('profile' => 'active', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'settings':
                $menu = array('profile' => '', 'author' => '', 'settings' => 'active', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'hidden_items':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => 'active', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'downloads':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => 'active', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'reviews':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => 'active', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'invoices':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => 'active', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'withdrawal':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => 'active', 'earnings' => '', 'statement' => '');
                break;
            case 'earnings':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => 'active', 'statement' => '');
                break;
            case 'statement':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => 'active');
                break;
            default :
                $menu = array('profile' => '', 'author' => 'active', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
        }
        return $menu;
    }

}