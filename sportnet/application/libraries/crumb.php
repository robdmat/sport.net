<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crumb {

    private $breadcrumbs = array();
    private $separator = '<li class="saparate">&nbsp;/&nbsp;</li>';
    private $start = '<ul class="breadcrumb">';
    private $end = '</ul>';

    public function __construct($params = array()) {
        if (count($params) > 0) {
            $this->initialize($params);
        }
    }

    private function initialize($params = array()) {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->{'_' . $key})) {
                    $this->{'_' . $key} = $val;
                }
            }
        }
    }

    function add($title, $href, $class = '') {
        if (!$title OR ! $href)
            return;
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href, 'class' => $class);
    }

    function output() {

        if ($this->breadcrumbs) {

            $output = $this->start;

            foreach ($this->breadcrumbs as $key => $crumb) {
                if ($key) {
                    $output .= $this->separator;
                }

                if (end(array_keys($this->breadcrumbs)) == $key) {
                    $output .= '<li class="' . $crumb['class'] . '">' . $crumb['title'] . '</li>';
                } else {
                    $output .= '<a  href="' . $crumb['href'] . '">' . $crumb['title'] . '</a>';
                }
            }

            return $output . $this->end . PHP_EOL;
        }

        return '';
    }

}
