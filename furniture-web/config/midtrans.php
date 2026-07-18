<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,

    // Persentase DP yang bisa dipilih pelanggan
    'dp_options' => array_map('intval', explode(',', env('MIDTRANS_DP_OPTIONS', '30,50'))),

    // Payment methods yang diaktifkan
    'enabled_payments' => [
        // Kartu Kredit/Debit
        'credit_card',
        // Bank Transfer Virtual Account
        'bca_va',
        'bni_va',
        'bri_va',
        'permata_va',
        'other_va', // Mandiri Bill, CIMB Niaga, dll
        // E-Wallet
        'gopay',
        'shopeepay',
        'qris',
        // Convenience Store
        'indomaret',
        'alfamart',
        // Installment & Online Banking
        'bca_klikpay',
        'bca_klikbca',
        'cimb_clicks',
        'danamon_online',
        'akulaku',
    ],

    // Konfigurasi Credit Card
    'credit_card' => [
        'secure' => true, // 3D Secure
        'installment' => [
            'required' => false,
            'terms' => [
                'bni' => [3, 6, 12],
                'mandiri' => [3, 6, 12],
                'cimb' => [3],
                'bca' => [3, 6, 12],
                'mega' => [3, 6, 12],
            ],
        ],
    ],

    // Durasi expiry transaksi
    'expiry' => [
        'unit' => 'day', // hour, day, week
        'duration' => 1, // 1 hari
    ],
];
