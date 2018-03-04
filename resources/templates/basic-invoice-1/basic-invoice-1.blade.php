@extends('nw-report::layouts.base', [
    'marginLeft' => '30px',
    'marginRight' => '30px',
])

@section('title', $title or 'Invoice')

@section('style')
    <style>
        body {
        }

        *,
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            display: table;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

        * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        div.title {
            text-align: center;
            font-size: 22pt;
            font-weight: bold
        }

        hr {
            border-top: 1px solid #000
        }

        div.summary {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 20px
        }

        td.np {
            padding: 0 !important;
            margin: 0 !important;
        }

        table.lineItems {
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
        }

        table.lineItems th {
            border: 1px solid #000;
            padding: 5px 10px;
            font-size: 12px;
        }

        table.lineItems td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px 10px
        }

        table.lineItems td.total-label {
            text-align: right;
            border-left: none;
        }

        table.lineItems td.total-amount {
            border: 1px solid #000;
            text-align: right
        }

        table.lineItems td.total-important {
            font-weight: bold;
        }

        table.lineItems tr.lastLineItem td {
            border-bottom: 1px solid #000;

        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            background-color: white;
            height: 60px;
        }
    </style>
@endsection

@section('content')

    <div style="padding: 20px;">
        <!-- HEADER -->
        <div class="title" style="height: 50px;">

            @if(isset($logoUrl) && !empty($logoUrl))
                <div style="float:right">
                    <img src="{{ $logoUrl }}" width="220">
                </div>
            @endif

            <div style="float:left; font-size: 25px;margin-top:7px;">
                FATURA Nº {{ $id or '**' }}
            </div>
        </div>
        <hr/>

        <!-- CUSTOMER & BUSINESS DETAILS -->
        <div style="margin-top: 20px">
            <div class="pull-right" style="padding-left: 20px">
                <div data-bind="text: Seller" style="font-weight: bold"></div>
                <div data-bind="foreach: SellerContactDetails">
                    <div data-bind="text: $data">
                    </div>
                </div>
            </div>
            <div class="pull-right" style="padding-right: 20px; border-right: 1px solid #000">

                @if(isset($createdAt) && !empty($createdAt) && ($createdAt instanceof DateTime))
                    <div style="font-weight: bold; text-align: right">Lançamento</div>
                    <div data-bind="text: IssueDate" style="text-align: right; margin-bottom: 10px">
                        {{ $createdAt->format('d/m/Y') }}
                    </div>
                @endif

                @if(isset($finishedAt) && !empty($finishedAt) && ($finishedAt instanceof DateTime))
                    <div style="font-weight: bold; text-align: right">Data liberação</div>
                    <div data-bind="text: DueDate" style="text-align: right; margin-bottom: 10px">
                        {{ $finishedAt->format('d/m/Y') }}
                    </div>
                @endif

                @if(isset($reference) && !empty($reference))
                    <div style="font-weight: bold; text-align: right">Referência</div>
                    <div data-bind="text: Number" style="text-align: right; margin-bottom: 10px">
                        {{ $reference }}
                    </div>
                @endif

            </div>


            @if(isset($customer) && is_array($customer))
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align: right; font-weight: bold; padding-right: 20px">Cliente</td>
                        <td>

                            @if(isset($customer['id']) && !empty($customer['id']))
                                #{{ $customer['id']  }}<br>
                            @endif

                            @if(isset($customer['name']) && !empty($customer['name']))
                                {{ $customer['name']  }}<br>
                            @endif

                            @if(isset($customer['email']) && !empty($customer['email']))
                                {{ $customer['email']  }}
                            @endif

                        </td>
                    </tr>
                    @if(isset($customer['address']) && !empty($customer['address']))
                        <tr>
                            <td></td>
                            <td>
                                <div data-bind="foreach: CustomerAddressLines">
                                    {{ $customer['address'] }}
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            @endif

            <div style="clear: both"></div>

        </div>
        <!-- LINE ITEMS -->
        <div class="summary" data-bind="text: Summary"></div>
        <table class="lineItems" cellspacing="0" cellpadding="0"
               style="max-width: 100% !important;width:100%; margin-left:-5px;">
            <thead>
            <tr>
                <th style="text-align: right; width: 10px">#</th>
                <th style="text-align: left; width: 200px">Descrição</th>
                <th style="text-align: center; width: 20px">Qtd.</th>
                <th style="text-align: right; width: 55px">Valor (BRL)</th>
                <th style="text-align: right; width: 55px">Total (BRL)</th>
            </tr>
            </thead>
            <tbody>

            @foreach($items as $item)
                <tr>
                    <td style="text-align: right">{{ $item['id'] }}</td>
                    <td style="text-align: left">{{ $item['name'] }}</td>
                    <td style="text-align: center">{{ number_format($item['quantity'], 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($item['value'], 2, ',', '.') }} BRL</td>
                    <td style="text-align: right">{{ number_format($item['value'] * $item['quantity'], 2, ',', '.') }}
                        BRL
                    </td>
                </tr>
            @endforeach

            </tbody>
            <tbody>

            <tr class="lastLineItem">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @if(isset($extraFees))
                <tr data-bind="visible: Total != Subtotal">
                    <td colspan="4" class="total-label">Sub Total</td>
                    <td class="total-amount">
                        @if(isset($totalAmount))
                            {{ number_format($totalAmount, 2, ',', '.') }} BRL
                        @else
                            0 BRL
                        @endif
                    </td>
                </tr>
            </tbody>

            <tbody data-bind="visible: TaxComponents.length > 0, foreach: TaxComponents">
            <tr>
                <td colspan="4" class="total-label">
                    <span>Taxas</span>
                </td>
                <td class="total-amount"> {{ number_format($extraFees, 2, ',', '.') }} BRL</td>
            </tr>

            <tr>
                <td colspan="4" class="total-label">
                    <span>Descontos</span>
                </td>
                <td class="total-amount"> {{ number_format($discounts, 2, ',', '.') }} BRL</td>
            </tr>
            </tbody>
            @endif


            <tbody>
            <tr>
                <td colspan="4" class="total-label total-important">Total</td>
                <td class="total-amount total-important">
                    {{ number_format($totalAmount + $extraFees - $discounts, 2, ',', '.') }} BRL
                </td>
            </tr>
            </tbody>

        </table>

    @if(isset($notes) &&!empty($notes))
        <!-- NOTES -->
            <div data-bind="foreach: Notes">
                <div data-bind="text: $data">
                    <br>
                    <b>OBSERVAÇÕES:</b>
                    <br>
                    <br>

                    {!! $notes !!}

                </div>
            </div>
        @endif

        <footer>
            @if($attachBarcode === true)
                <div style="float:right;margin-right:0px;">
                    <?php
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($reference,
                            $barcodeType)).'">';
                    ?>
                </div>
            @endif

        </footer>

    </div>

@endsection