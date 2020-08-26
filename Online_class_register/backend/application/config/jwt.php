<?php
// Store your secret key here
// Make sure you use better, long, more random key than this
$config['key'] = "owthub"; // secret key
$config['iss'] = "http://127.0.0.1/dashboard/codeigniter-jwt/"; // domain name
$config['aud'] = "http://127.0.0.1/dashboard/codeigniter-jwt/"; // domain name
$config['iat'] = time(); // current time
$config['nbf'] = $config['iat']; // when generate its ready
$config['exp'] = $config['iat'] + 1*36000; // valid for 10 h after generate
