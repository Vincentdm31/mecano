<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #f7f7f7;
            font-size: 10px;
            padding: 5pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            width: 50%;
            padding: 0.75rem;
            vertical-align: top;
            border-top: 2px solid #f7f7f7;
            background-color: #d6e0ff;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #f7f7f7;
        }

        .table tbody+tbody {
            border-top: 2px solid blue;
        }

        .mt-1 {
            margin-top: 0.2rem !important;
        }

        .mb-1 {
            padding-bottom: 1rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .pt-4 {
            padding-top: 2rem !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
            background: #182654 !important;
            color: #f7f7f7;
        }

        .border-0 {
            border: none !important;
        }

        .name {
            width: 80% !important;
        }

        .infos {
            font-size: 1.5rem;
        }

        .total {
            background: #182654 !important;
            color: #f7f7f7;
        }

        .company {
            background-color: purple;
            padding: 1px;
            color: white;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <table class="table mt-1">
        <tbody>
            <tr>
                <td class="border-0 pl-0 name" width="70%">
                    <h4 class="text-uppercase pt-4">
                        <strong>{{ $invoice->name }}</strong>
                    </h4>
                </td>
                <td class="border-0 pl-0" width="30%">
                    @if($invoice->logo)
                    <img src="{{ $invoice->getLogo() }}" alt="logo" height="80">
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Seller - Buyer --}}
    <table class="table">
        <thead>
            <tr>
                <th class="border-0 pl-0 party-header" width="48.5%">
                    Prestaire
                </th>
                <th></th>
                <th class="border-0 pl-0 party-header">
                    Client
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-0">
                    @if($invoice->seller->name)
                    <p class="seller-name">
                        <strong>{{ $invoice->seller->name }}</strong>
                    </p>
                    @endif

                    @if($invoice->seller->address)
                    <p class="seller-address">
                        {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
                    </p>
                    @endif

                    @if($invoice->seller->code)
                    <p class="seller-code">
                        {{ __('invoices::invoice.code') }}: {{ $invoice->seller->code }}
                    </p>
                    @endif

                    @if($invoice->seller->vat)
                    <p class="seller-vat">
                        {{ __('invoices::invoice.vat') }}: {{ $invoice->seller->vat }}
                    </p>
                    @endif

                    @if($invoice->seller->phone)
                    <p class="seller-phone">
                        {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                    </p>
                    @endif

                    @foreach($invoice->seller->custom_fields as $key => $value)
                    <p class="seller-custom-field">
                        {{ ucfirst($key) }}: {{ $value }}
                    </p>
                    @endforeach
                </td>
                <td class="border-0"></td>
                <td class="px-0">
                    @if($invoice->buyer->name)
                    <p class="buyer-name">
                        <strong>{{ $invoice->buyer->name }}</strong>
                    </p>
                    @endif

                    @if($invoice->buyer->address)
                    <p class="buyer-address">
                        {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                    </p>
                    @endif

                    @if($invoice->buyer->code)
                    <p class="buyer-code">
                        {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}
                    </p>
                    @endif

                    @if($invoice->buyer->vat)
                    <p class="buyer-vat">
                        {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                    </p>
                    @endif

                    @if($invoice->buyer->phone)
                    <p class="buyer-phone">
                        {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                    </p>
                    @endif

                    @foreach($invoice->buyer->custom_fields as $key => $value)
                    <p class="buyer-custom-field">
                        {{ ucfirst($key) }}: {{ $value }}
                    </p>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table mt-1">
        <tbody>
            <tr>
                <td class="infos">Informations Générales</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <p><strong>{{ __('invoices::invoice.serial') }} </strong>{{ $invoice->getSerialNumber() }}</p>
                    <p><strong>{{ __('invoices::invoice.date') }}:</strong> {{ $invoice->getDate() }}</p>
                    <p><strong>Créé par: </strong>{{ $invoice->createdBy }}</p>
                    <p><strong>Créée le: </strong>{{ $invoice->createdAt }}</p>
                </td>
                <td>
                    <p><strong>Marque: </strong>{{ $invoice->brand }}</p>
                    <p><strong>Modèle: </strong>{{ $invoice->model }}</p>
                    <p><strong>Immatriculation: </strong>{{ $invoice->immat }}</p>
                    <p><strong>Kilométrage: </strong>{{ $invoice->km }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>{!! $invoice->notes !!}</p>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    {{-- Table --}}
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
                @if($invoice->hasItemUnits)
                <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
                @endif
                <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>
                @if($invoice->hasItemDiscount)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
                @endif
                @if($invoice->hasItemTax)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
                @endif
                <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>
            </tr>
        </thead>
        <tbody>
            {{-- Items --}}
            @foreach($invoice->items as $item)
            <tr>
                <td class="pl-0">{{ $item->title }}</td>
                @if($invoice->hasItemUnits)
                <td class="text-center">{{ $item->units }}</td>
                @endif
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->price_per_unit) }}
                </td>
                @if($invoice->hasItemDiscount)
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->discount) }}
                </td>
                @endif
                @if($invoice->hasItemTax)
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->tax) }}
                </td>
                @endif

                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($item->sub_total_price) }}
                </td>
            </tr>
            @endforeach
            {{-- Summary --}}
            @if($invoice->hasItemOrInvoiceDiscount())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0 test">{{ __('invoices::invoice.total_discount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_discount) }}
                </td>
            </tr>
            @endif
            @if($invoice->taxable_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.taxable_amount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                </td>
            </tr>
            @endif
            @if($invoice->tax_rate)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->tax_rate }}%
                </td>
            </tr>
            @endif
            @if($invoice->hasItemOrInvoiceTax())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_taxes) }}
                </td>
            </tr>
            @endif
            @if($invoice->shipping_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                </td>
            </tr>
            @endif
            <tr class="test">
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 total "></td>
                <td class="text-right pl-0 total">{{ __('invoices::invoice.total_amount') }}</td>
                <td class="text-right pr-0 total-amount">
                    {{ $invoice->formatCurrency($invoice->total_amount) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="company text-center">
        <p class="text-center">SAS ALCIS LOCATION</p>
        <p>Siège social : 130, Route de Castres - 31130 BALMA</p>
        <p>Tél : 05 61 83 33 58 - Fax : 05 62 18 54 10</p>
        <p>SIRET : 750 642 688 00022 - APE : 4520B - N°Intracom : FR35 750 462 688 - RCS TOULOUSE 750 642 688</p>
        <p>S.A.S au capital de 7 500 €uros</p>
    </div>


    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
</body>

</html>