<?php

    mysql_connect("baze.zenon.net:64000", "vh41996", "t9TyicJbDr") or die (mysql_error());
    mysql_select_db("vh41996") or die (mysql_error());

    mysql_query("set character_set_client	='cp1251'");
    mysql_query("set character_set_results	='cp1251'");
    mysql_query("set collation_connection	='cp1251_general_ci'");
	
	
	// сюда вынесем обработку суперглобальных массивов от слешей
	// http://phpfaq.ru/slashes
	
    function slashes(&$el)
	{
		if (is_array($el))
			foreach($el as $k=>$v)
				slashes($el[$k]);
		else $el = stripslashes($el); 
    }
	
	if (ini_get('magic_quotes_gpc'))
	{
	    slashes($_GET);
	    slashes($_POST);    
	    slashes($_COOKIE);
	}



?>