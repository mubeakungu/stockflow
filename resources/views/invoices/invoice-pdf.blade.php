<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        @page { margin: 32px 40px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        .header td { vertical-align: middle; }
        .title { font-size: 26px; color: #0a2a5e; text-align: right; }
        .logo { max-height: 60px; max-width: 220px; }
        .shop-name { font-size: 16px; font-weight: bold; }
        hr { border: 0; border-top: 1px solid #ddd; margin: 14px 0; }
        .meta td { padding: 2px 0; }
        .parties td { vertical-align: top; width: 50%; line-height: 1.5; }
        .items { margin-top: 16px; border: 1px solid #ddd; }
        .items th { background: #f5f5f5; text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        .items td { padding: 8px; border-bottom: 1px solid #eee; }
        .items tfoot td { background: #f5f5f5; font-weight: bold; }
        .r { text-align: right; }
        .c { text-align: center; }
        .status { display: inline-block; padding: 2px 8px; border-radius: 3px; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-partial { background: #fff3cd; color: #856404; }
        .status-due { background: #f8d7da; color: #721c24; }
        .kra { margin-top: 18px; border: 1px solid #ddd; }
        .kra td { padding: 10px; vertical-align: top; font-size: 10px; line-height: 1.6; word-break: break-all; }
        .note { margin-top: 24px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
@php
    $logoPath = $settings && $settings->logo ? public_path('storage/logo/' . $settings->logo) : null;
@endphp

<table class="header">
    <tr>
        <td>
            @if ($logoPath && is_file($logoPath))
                <img class="logo" src="{{ $logoPath }}" alt="">
            @else
                <span class="shop-name">{{ $settings->shop_name ?? config('app.name') }}</span>
            @endif
        </td>
        <td class="title">Invoice</td>
    </tr>
</table>
<hr>

<table class="meta">
    <tr>
        <td><strong>Date:</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}</td>
        <td class="r"><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</td>
    </tr>
    <tr>
        <td></td>
        <td class="r"><span class="status status-{{ $invoice->status }}">{{ $invoice->status }}</span></td>
    </tr>
</table>
<hr>

<table class="parties">
    <tr>
        <td>
            <strong>Pay To:</strong><br>
            {{ $settings->shop_name ?? config('app.name') }}<br>
            {{ config('shop.address_line1') }}<br>
            {{ config('shop.address_line2') }}<br>
            {{ config('shop.email') }}<br>
            {{ config('shop.phone') }}
            @if (config('shop.kra_pin'))<br><strong>PIN:</strong> {{ config('shop.kra_pin') }}@endif
        </td>
        <td class="r">
            <strong>Invoiced To:</strong><br>
            {{ optional($invoice->customer)->name }}<br>
            {{ optional($invoice->customer)->address }}<br>
            @if (optional($invoice->customer)->location){{ $invoice->customer->location }}<br>@endif
            {{ optional($invoice->customer)->phone }}
            @if (optional($invoice->customer)->kra_pin)<br><strong>PIN:</strong> {{ $invoice->customer->kra_pin }}@endif
        </td>
    </tr>
</table>

<table class="items">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Serial No</th>
            <th class="c">Qty</th>
            <th class="r">Rate</th>
            <th class="r">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $key => $product)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->serial_no ?? '-' }}</td>
                <td class="c">{{ $product->quantity }}</td>
                <td class="r">@ksh($product->price)</td>
                <td class="r">@ksh($product->total)</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><td colspan="5" class="r">Total:</td><td class="r">@ksh($invoice->total)</td></tr>
        <tr><td colspan="5" class="r">Paid:</td><td class="r">@ksh($invoice->total - $invoice->due)</td></tr>
        <tr><td colspan="5" class="r">Due:</td><td class="r">@ksh($invoice->due)</td></tr>
    </tfoot>
</table>

@if ($invoice->isKraSigned())
    <table class="kra">
        <tr>
            <td>
                <strong>KRA eTIMS</strong><br>
                @if ($invoice->kra_cu_serial_no)CU Serial No: {{ $invoice->kra_cu_serial_no }}<br>@endif
                CU Invoice No: {{ $invoice->kra_cu_invoice_no }}<br>
                @if ($invoice->kra_signed_at)Signed: {{ $invoice->kra_signed_at->format('d/m/Y H:i:s') }}<br>@endif
                @if ($invoice->kra_internal_data)Internal Data: {{ $invoice->kra_internal_data }}<br>@endif
                @if ($invoice->kra_receipt_signature)Receipt Signature: {{ $invoice->kra_receipt_signature }}@endif
            </td>
            <td class="r" style="width: 130px;">
                <img src="{{ \App\Support\QrCode::dataUri($invoice->kra_qr_url, 120) }}" width="110" height="110" alt=""><br>
                <small>Scan to verify with KRA</small>
            </td>
        </tr>
    </table>
@endif

<p class="note"><strong>NOTE:</strong> This is a computer generated receipt and does not require a physical signature.</p>
</body>
</html>
