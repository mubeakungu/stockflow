<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt {{ $invoice->invoice_no }}</title>
    <style>
        /* 80mm thermal roll: ~72mm printable width, height grows with content */
        @page { size: 80mm auto; margin: 0; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; background: #e9e9e9; }
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000; line-height: 1.35; }
        .receipt { width: 80mm; margin: 16px auto; padding: 4mm; background: #fff; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .shop { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .logo { max-width: 40mm; max-height: 20mm; margin-bottom: 2mm; }
        .rule { border: 0; border-top: 1px dashed #000; margin: 2mm 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 0.5mm 0; vertical-align: top; }
        .item-name { word-break: break-word; }
        .item-detail td { padding-bottom: 1mm; }
        .totals td { padding: 0.6mm 0; }
        .grand td { font-size: 15px; font-weight: bold; }
        .kra td { font-size: 11px; }
        .kra-code { font-size: 10px; word-break: break-all; margin-top: 1mm; }
        .qr { margin: 2mm 0 1mm; }
        .qr svg { width: 38mm; height: 38mm; }
        .status { display: inline-block; border: 1px solid #000; padding: 0.5mm 2mm; font-weight: bold; text-transform: uppercase; }
        .actions { width: 80mm; margin: 0 auto 16px; display: flex; gap: 8px; }
        .actions a, .actions button {
            flex: 1; padding: 10px; font: 600 14px system-ui, sans-serif; text-align: center; cursor: pointer;
            border: 1px solid #1abc9c; border-radius: 4px; background: #1abc9c; color: #fff; text-decoration: none;
        }
        .actions a { background: #fff; color: #1abc9c; }
        @media print {
            html, body { background: #fff; }
            .receipt { margin: 0; width: 80mm; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
@php
    $shopName = $settings->shop_name ?? config('app.name');
    $paid = $invoice->total - $invoice->due;
    $logoFile = $settings && $settings->logo ? 'storage/logo/' . $settings->logo : null;
@endphp

<div class="receipt">
    <div class="center">
        @if ($logoFile && is_file(public_path($logoFile)))
            <img class="logo" src="{{ asset($logoFile) }}" alt=""><br>
        @endif
        <div class="shop">{{ $shopName }}</div>
        <div>{{ config('shop.address_line1') }}</div>
        <div>{{ config('shop.address_line2') }}</div>
        <div>Tel: {{ config('shop.phone') }}</div>
        <div>{{ config('shop.email') }}</div>
        @if (config('shop.kra_pin'))
            <div class="bold">PIN: {{ config('shop.kra_pin') }}</div>
        @endif
    </div>

    <hr class="rule">
    <div class="center bold">SALES RECEIPT</div>
    <hr class="rule">

    <table>
        <tr><td>Receipt #</td><td class="right">{{ $invoice->invoice_no }}</td></tr>
        <tr><td>Date</td><td class="right">{{ $invoice->created_at->format('d/m/Y H:i') }}</td></tr>
        @if ($invoice->customer)
            <tr><td>Customer</td><td class="right">{{ $invoice->customer->name }}</td></tr>
            @if ($invoice->customer->phone)
                <tr><td>Phone</td><td class="right">{{ $invoice->customer->phone }}</td></tr>
            @endif
            @if ($invoice->customer->kra_pin)
                <tr><td>Customer PIN</td><td class="right">{{ $invoice->customer->kra_pin }}</td></tr>
            @endif
        @endif
    </table>

    <hr class="rule">

    <table>
        @foreach ($products as $product)
            <tr><td colspan="2" class="item-name bold">{{ $product->name }}</td></tr>
            @if ($product->serial_no)
                <tr><td colspan="2">S/N: {{ $product->serial_no }}</td></tr>
            @endif
            <tr class="item-detail">
                <td>{{ $product->quantity }} x {{ number_format($product->price, 0) }}</td>
                <td class="right">{{ number_format($product->total, 0) }}</td>
            </tr>
        @endforeach
    </table>

    <hr class="rule">

    <table class="totals">
        <tr><td>Items</td><td class="right">{{ $products->sum('quantity') }}</td></tr>
        <tr class="grand"><td>TOTAL</td><td class="right">@ksh($invoice->total)</td></tr>
        <tr><td>Paid</td><td class="right">@ksh($paid)</td></tr>
        <tr><td>Payment</td><td class="right">{{ $invoice->paymentMethodLabel() }}</td></tr>
        @if ($invoice->payment_reference)
            <tr><td>{{ $invoice->payment_method === 'mpesa' ? 'M-Pesa code' : 'Reference' }}</td><td class="right">{{ $invoice->payment_reference }}</td></tr>
        @endif
        @if ($invoice->due > 0)
            <tr class="bold"><td>Balance due</td><td class="right">@ksh($invoice->due)</td></tr>
        @endif
    </table>

    <div class="center" style="margin-top: 2mm;"><span class="status">{{ $invoice->status }}</span></div>

    <hr class="rule">
    @if ($invoice->isKraSigned())
        <div class="center bold">KRA eTIMS</div>
        <table class="kra">
            @if ($invoice->kra_cu_serial_no)
                <tr><td>CU Serial No</td><td class="right">{{ $invoice->kra_cu_serial_no }}</td></tr>
            @endif
            <tr><td>CU Invoice No</td><td class="right">{{ $invoice->kra_cu_invoice_no }}</td></tr>
            @if ($invoice->kra_signed_at)
                <tr><td>Signed</td><td class="right">{{ $invoice->kra_signed_at->format('d/m/Y H:i:s') }}</td></tr>
            @endif
        </table>
        @if ($invoice->kra_internal_data)
            <div class="kra-code">Internal Data:<br>{{ $invoice->kra_internal_data }}</div>
        @endif
        @if ($invoice->kra_receipt_signature)
            <div class="kra-code">Receipt Signature:<br>{{ $invoice->kra_receipt_signature }}</div>
        @endif
        <div class="center qr">{!! \App\Support\QrCode::svg($invoice->kra_qr_url, 150) !!}</div>
        <div class="center">Scan to verify with KRA</div>
    @else
        <div class="center">KRA eTIMS: pending</div>
    @endif

    <hr class="rule">
    <div class="center">{{ config('shop.receipt_footer') }}</div>
    <div class="center" style="margin-top: 3mm;">&nbsp;</div>
</div>

<div class="actions">
    <a href="{{ route('invoices.show', $invoice) }}">Back</a>
    <button type="button" onclick="window.print()">Print</button>
</div>

@if (request()->boolean('print'))
    <script>window.addEventListener('load', function () { window.print(); });</script>
@endif
</body>
</html>
