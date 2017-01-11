<?php

function getParam($name, $defaultValue = '') {
	return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
}

$defaultValue = 'is empty';

$needleValues = ['var1', 'var2', 'var3'];


foreach ($needleValues as $valueName) {
	echo $valueName . '  ' . getParam($valueName, $defaultValue) . "<br/>";
}
