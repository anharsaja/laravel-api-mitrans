<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-e85E2nJhfMlqEkcmzwnFx_6R'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-uNxYxTFu7sJW6kAm'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
