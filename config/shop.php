<?php

// Shop contact details printed on invoices and receipts.
// The shop name comes from Settings; set these in .env to change the rest.
return [
    'address_line1' => env('SHOP_ADDRESS_LINE1', '40600'),
    'address_line2' => env('SHOP_ADDRESS_LINE2', 'Siaya, Siaya-Road'),
    'email' => env('SHOP_EMAIL', 'berrylwasonga@gmail.com'),
    'phone' => env('SHOP_PHONE', '0792827238'),
    'receipt_footer' => env('SHOP_RECEIPT_FOOTER', 'Thank you for shopping with us!'),
];
