<?php

return [
    'secret_key' => env('TOYYIBPAY_SECRET_KEY', ''),
    'category_code' => env('TOYYIBPAY_CATEGORY_CODE', ''),
    'api_url' => env('TOYYIBPAY_API_URL', 'https://dev.toyyibpay.com/index.php/api'),
    'redirect_url' => env('TOYYIBPAY_REDIRECT_URL', 'https://dev.toyyibpay.com'),
    
    // URLs for payment callbacks
    'return_url' => '/payment/status',
    'callback_url' => '/payment/callback',
    'notification_url' => '/payment/notification',
];