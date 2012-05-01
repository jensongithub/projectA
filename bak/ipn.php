<?php  
      
    // read the post from PayPal system and add 'cmd'  
    $req = 'cmd=_notify-validate';  
    foreach ($_POST as $key => $value) {  
		$value = urlencode(stripslashes($value));  
		$req .= "&$key=$value";
    }

    // post back to PayPal system to validate  
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";  
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";  
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";  
      
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);  
      
    if (!$fp) {  
		// HTTP ERROR  
    } else {  
		fputs ($fp, $header . $req);  
		while (!feof($fp)) {  
			$res = fgets ($fp, 1024); 
		
			$lfp=fopen("ipn.log",'w');
			fwrite($lfp, "WWW".$req . "\n\n".$res); 
		if (preg_match("/VERIFIED/i", $res)){
			// PAYMENT VALIDATED & VERIFIED!  
			$lfp=fopen("ipn.log",'a');
			fwrite($lfp, "OKOK".$req . "\n\n".$res);
		}	  
		else if (preg_match("/INVALID/i", $res)){
			// PAYMENT INVALID & INVESTIGATE MANUALY!  
			$lfp=fopen("ipn.log",'a');
				fwrite($lfp, "FAIL!!".$req . "\n\n".$res); 
		}
	}
	fclose ($lfp);
	fclose ($fp);	
	}  
