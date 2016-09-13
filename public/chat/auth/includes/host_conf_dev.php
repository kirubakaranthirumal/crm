<?php

error_reporting(0);
ob_start();
		$host="10.11.0.187"; // Your Host Name
        $user_name="followondbuser";  // username
        $password="followondbpa55"; // Password
		$db="iptl_production"; // Database Name
        define("C_DB_HOST",$host);
        define("C_DB_USER",$user_name);
        define("C_DB_PASS",$password);
        define("C_DB_NAME",$db);
        define("SERVER_HOST","");
        define("ADD_ROW","#A0A0A0");
        define("EVEN_ROW","#B0B0B0");
		
		//Pagination
		
		define("REC_PAGE",10);
		define("START_YEAR",2010);
		define("END_YEAR",2025);
		define("COMPANY_NAME","Technology Frontiers India (Pvt) Ltd.");



		
?>