<?php
function input($type, $name, $value = NULL, $placeholder = NULL){
	return "<input type='".$type."' name='".$name."' value='". $value ."' placeholder='".$placeholder."'>";
}