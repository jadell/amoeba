<?php
function loaderTestAutoloader($sClass)
{
	$sLibPath = 'lib/';
	$sClassFile = str_replace('\\','/',$sClass).'.php';
	$sClassPath = $sLibPath.$sClassFile;
	
	if (file_exists($sClassPath)) {
		require($sClassPath);
	}
}

chdir('..');
spl_autoload_register('loaderTestAutoloader');
