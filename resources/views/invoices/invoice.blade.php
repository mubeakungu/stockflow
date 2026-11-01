<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="icon" />
    <title>General Invoice - Koice</title>
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts
======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
        type='text/css'>

    <!-- Stylesheet
======================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <style>
        #logo {
            max-width: 300px;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!-- Container -->
    <div class="container-fluid invoice-container">
        <!-- Header -->
        <header>
            <div class="row align-items-center">
                <div class="col-sm-7 text-center text-sm-start mb-3 mb-sm-0">
                    <img id="logo" src="{{ asset('storage/logo/'.$settings->logo) }}" title="Koice" alt="Koice" />
                </div>
                <div class="col-sm-5 text-center text-sm-end">
                    <h4 class="text-7 mb-0">Invoice</h4>
                </div>
            </div>
            <hr>
        </header>

        <!-- Main Content -->
        <main>
            <div class="row">
                <div class="col-sm-6"><strong>Date:</strong> {{ $invoice->created_at->format('d/m/y') }}</div>
                <div class="col-sm-6 text-sm-end"> <strong>Invoice No:</strong> {{ $invoice->invoice_no }}</div>

            </div>
            <hr>
            <div class="row">
                <div class="col-6"> <strong>Pay To:</strong>
                    <address>
                        {{ $settings->shop_name }}<br />
                        {{ config('shop.address_line1') }}<br />
                        {{ config('shop.address_line2') }}<br />
                        {{ config('shop.email') }}<br />
                        {{ config('shop.phone') }}
                        @if (config('shop.kra_pin'))<br /><strong>PIN:</strong> {{ config('shop.kra_pin') }}@endif
                    </address>
                </div>
                <div class="col-6 text-end"> <strong>Invoiced To:</strong>
                    <address>
                        {{ $invoice->customer->name }}<br />
                        {{ $invoice->customer->address }}<br />
                        {{ $invoice->customer->location }}<br />
                        {{ $invoice->customer->phone }}
                        @if ($invoice->customer->kra_pin)<br /><strong>PIN:</strong> {{ $invoice->customer->kra_pin }}@endif
                    </address>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="card-header">
                                <tr>
                                    <td class="col-2"><strong>#</strong></td>
                                    <td class="col-2"><strong>Product</strong></td>
                                    <td class="col-2"><strong>Serial No</strong></td>
                                    <td class="col-1 text-center"><strong>QTY</strong></td>
                                    <td class="col-2 text-center"><strong>Rate</strong></td>
                                    <td class="col-2 text-end"><strong>Amount</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td class="col-2">{{ $key + 1 }}</td>
                                        <td class="col-2 text-1">{{ $product->name }}</td>
                                        <td class="col-2">{{ $product->serial_no ?? '-' }}</td>
                                        <td class="col-1 text-center">{{ $product->quantity }}</td>
                                        <td class="col-2 text-center">@ksh($product->price)</td>
                                        <td class="col-2 text-end">@ksh($product->total)</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot class="card-footer">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end">@ksh($invoice->total)</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Paid:</strong></td>
                                    <td class="text-end">@ksh($invoice->total - $invoice->due)</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end border-bottom-0"><strong>Due:</strong></td>
                                    <td class="text-end border-bottom-0">@ksh($invoice->due)</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @if ($invoice->isKraSigned())
                <div class="row align-items-center mt-3">
                    <div class="col-sm-9 text-1" style="word-break: break-all;">
                        <strong>KRA eTIMS</strong><br />
                        @if ($invoice->kra_cu_serial_no)CU Serial No: {{ $invoice->kra_cu_serial_no }}<br />@endif
                        CU Invoice No: {{ $invoice->kra_cu_invoice_no }}<br />
                        @if ($invoice->kra_signed_at)Signed: {{ $invoice->kra_signed_at->format('d/m/Y H:i:s') }}<br />@endif
                        @if ($invoice->kra_internal_data)Internal Data: {{ $invoice->kra_internal_data }}<br />@endif
                        @if ($invoice->kra_receipt_signature)Receipt Signature: {{ $invoice->kra_receipt_signature }}@endif
                    </div>
                    <div class="col-sm-3 text-center">
                        {!! \App\Support\QrCode::svg($invoice->kra_qr_url, 120) !!}
                        <div class="text-1">Scan to verify with KRA</div>
                    </div>
                </div>
            @else
                <p class="text-1 text-muted mt-3 mb-0">KRA eTIMS: pending</p>
            @endif
        </main>
        <!-- Footer -->
        <footer class="text-center mt-4">
            <p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical
                signature.</p>
            <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()"
                    class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a
                    href="{{ route('invoices.download', $invoice) }}" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>
                    Download PDF</a> <a href="{{ route('invoices.receipt', $invoice) }}?print=1" target="_blank"
                    class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-receipt"></i> Receipt (80mm)</a> </div>
        </footer>
    </div>
</body>

</html>
