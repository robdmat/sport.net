<?php

//check for referal links
//https://gist.github.com/wmandai/8254829
function referal() {
    $CI = & get_instance();
    $cookie_value_set = $CI->input->cookie('_tm_ref', TRUE) ? $CI->input->cookie('_tm_ref', TRUE) : '';
    if ($CI->input->get('ref', TRUE) AND $cookie_value_set == '') {
// referred user so set cookie to ref=username
        $cookie = array(
            'name' => 'ref',
            'value' => $CI->input->get('ref', TRUE),
            'expire' => '7776000',
        );
        $CI->input->set_cookie($cookie);
        return TRUE;
    } elseif ($cookie_value_set == '') {
        $cookie = array(
            'name' => 'ref',
            'value' => 'sso',
            'expire' => '15552000',
        );
        $CI->input->set_cookie($cookie);
        return TRUE;
    } elseif ($cookie_value_set != '') {
//already referred so ignore
        return TRUE;
    } else {
        return TRUE;
    }
}

//end of hooks file