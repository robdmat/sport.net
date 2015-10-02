<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['active'] = 'default';

// Default upload configuration
$config["default"]['file_upload']['upload_path'] = "./uploads/avatar";
$config["default"]['file_upload']['encrypt_name'] = false;
$config["default"]['file_upload']['allowed_types'] = "jpg|jpeg|png|bmp|gif|pdf|doc|docx|xls|xlsx|rtf";
$config["default"]['image_lib']['image_library'] = 'gd2';
$config["default"]['image_lib']['create_thumb'] = false;
$config["default"]['image_lib']['maintain_ratio'] = false;
$config["default"]['image_lib']['width'] = 80;
$config["default"]['image_lib']['height'] = 80;

// Custom upload configuration
$config["cutsom"]['file_upload']['upload_path'] = "./uploads/docs";
$config["cutsom"]['file_upload']['encrypt_name'] = false;
$config["cutsom"]['file_upload']['allowed_types'] = "pdf|doc|docx|xls|xlsx|rtf";
