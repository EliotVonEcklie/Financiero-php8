<?php
//============================================================+
// File name   : tcpdf_include.php
// Begin       : 2008-05-14
// Last Update : 2013-05-14
//
// Description : Search and include the TCPDF library.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Search and include the TCPDF library.
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Include the main class.
 * @author Nicola Asuni
 * @since 2013-05-14
 */

// always load alternative config file for examples
require_once('config/tcpdf_config_alt.php');

// Include the main TCPDF library (search the library on the following directories).
$tcpdf_include_dirs = array(realpath('../tcpdf.php'), '/usr/share/php/tcpdf/tcpdf.php', '/usr/share/financiero/tcpdf/tcpdf.php', '/usr/share/php-tcpdf/tcpdf.php', '/var/www/tcpdf/tcpdf.php', '/var/www/html/financiero/tcpdf/tcpdf.php', '/usr/local/xampp/htdocs/financiero/tcpdf/tcpdf.php','/local/htdocs/financiero/tcpdf/tcpdf.php','tcpdf.php','barras/tcpdf.php','..barras/tcpdf.php');
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		//echo "siii $tcpdf_include_path  ";
		require_once($tcpdf_include_path);
			
		break;
	}
	else
	{
//	echo "nooo $tcpdf_include_path  ";
		}
}

//============================================================+
// END OF FILE
//============================================================+
