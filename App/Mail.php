<?php

namespace App;

use App\Config;
use Mailgun\Mailgun;

class Mail
{
	//funkcja która wysyła maila
    public static function send($to, $subject, $text,$html)
    {
		//mail("mikinarloch@gmail.com","Answer","Hope You Vote My Answer Up","From: me@you.com");
		//mail($to, $subject, $text, "From: mikolaj.narloch.programista@gmail.com");
		
		/*  $html = "From: mikolajnarloch@mikolajnarloch.pl \nContent-Type:".
							' text/plain;charset="UTF-8"'.
							"\nContent-Transfer-Encoding: 8bit";  */
		   mail($to, $subject, $text, $html);
		
		
		
		/*
        $mg = new Mailgun(Config::MAILGUN_API_KEY);
		
		
		
        $domain = Config::MAILGUN_DOMAIN;

        $mg->sendMessage($domain, ['from'   => 
		'mikinarloch@gmail.com',
                                   'to'      => $to,
                                   'subject' => $subject,
                                   'text'    => $text,
                                   'html'    => $html]);
								   
								   */
    }
}