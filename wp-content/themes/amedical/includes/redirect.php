<?php


add_action('template_redirect', 'amedical_404_redirect' );
function amedical_404_redirect() {
    if(is_404()) {
        if(file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'redirect_map.php')) {
            $redirect_map = include_once 'redirect_map.php';


            $request_uri =  trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');


            if(isset($redirect_map[$request_uri])) {
                if(is_string($redirect_map[$request_uri])) {
                    wp_redirect($redirect_map[$request_uri], 301);
                    die;
                }
            }


            if(preg_match('/^(lv|ru|en)\/(.*)$/Usi', $request_uri, $match)) {
                $lang = $match[1];
                $request_uri = $match[2];


                if(isset($redirect_map[$request_uri])) {
                    if(is_string($redirect_map[$request_uri])) {
                        wp_redirect($redirect_map[$request_uri], 301);
                        die;
                    } else {
                        wp_redirect(base_url() . '/shop/' . $lang . '/' . $request_uri, 301);
                        die;
                    }
                }
            }
        }
    }
}