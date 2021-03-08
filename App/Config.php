<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mikolajn_homebudgetmvc';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
	
	/* Secret key for hashing */
	
const SECRET_KEY = 'znczaXWPea4jyqzeiRjMlfhmhk3Q070X';
/*
	const MAILGUN_API_KEY= 'b0da1567beffa3162bf4015ddf54116f-4de08e90-b81304bf';
	/* 340609bcf968e5c2859949a7402b1956-4de08e90-a8ea7f8f */
/*moje domena do wysyłania maili
	const MAILGUN_DOMAIN = 'sandbox4a0f39651eb44129aa032905ca08c400.mailgun.org';
	
	*/
}
