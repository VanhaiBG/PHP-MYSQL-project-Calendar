<?php
function input($type, $name, $value = NULL, $placeholder = NULL){
	echo "<input type='".$type."' name='".$name."' value='". $value ."' placeholder='".$placeholder."'>";
}