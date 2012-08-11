<?php

function request($var, $default=NULL) {
	if(isset($_REQUEST[$var])) 
		return $_REQUEST[$var];
	else
		return $default;
}

function get($var, $default=NULL) {
	if(isset($_GET[$var])) 
		return $_GET[$var];
	else
		return $default;
}

function post($var, $default=NULL) {
	if(isset($_POST[$var])) 
		return $_POST[$var];
	else
		return $default;
}

function redirect($url) {
	header("Location: $url");
}

function output_json($data) {
	header("Content-Type: text/json");
	echo json_encode($data);
	exit();
}
