<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/27
 * Time: 23:40
 */
return [
    'consumer_key' => env('TWITTER_CONSUMER_KEY', ''),
    'consumer_secret' => env('TWITTER_CONSUMER_SECRET', ''),
    'access_token' => env('TWITTER_ACCESS_TOKEN', ''),
    'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET', ''),
    'callback_url' => env('TWITTER_CALLBACK_URL', ''),
];