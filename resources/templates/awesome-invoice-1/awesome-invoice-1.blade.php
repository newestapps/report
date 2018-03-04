@extends('nw-report::layouts.base', [
    'pageBackground' => '#f2f2f2',
    'marginTop' => 0,
    'marginLeft' => 0,
    'marginRight' => 0,
    'marginBottom' => 0,
])

@section('title', $title or 'Invoice')

@section('style')
    <style type="text/css">

        * {
            font-family: Helvetica, Arial, sans-serif;
            color: #333333;
        }

        .logo {
            position: absolute;
            top: 76px;
            left: 55px;
        }

        .title {
            position: absolute;
            top: 76px;
            right: 55px;
            font-size: 40px;
            text-transform: uppercase;
            font-weight: bold;
            width: 200px;
            color: #000000;
        }

        .to {
            position: absolute;
            top: 186px;
            left: 55px;
            font-size: 13px;
            line-height: 21px;
        }

        .to b {
            font-size: 20px;
        }

        .to span {
            font-size: 17px;
        }

        .invoice-info {
            position: absolute;
            top: 191px;
            right: 55px;
            font-size: 13px;
            line-height: 20px;
            width: 200px;
            color: #5c5c5c;
        }

        .total-due {
            position: absolute;
            top: 305px;
            right: 55px;
            width: 200px;
            font-size: 25px;
            line-height: 30px;
            color: #333333;
        }

        .total-due .line2 {
            font-weight: bold;
            color: {{ $color or '#000000' }};
        }

        .table-start {
            left: 0;
            width: 100%;
            right: -101px;
        }

        .table-start table {
            width: 100%;
            border-spacing: 0;
            text-align: left;
        }

        .table-start table tr.head {
            background-color: {{ $color or '#000000' }};
            border-color: {{ $color or '#000000' }};
        }

        .table-start table tr.head th {
            color: {{ \Newestapps\Report\Helpers\Color::getContrastColor(($color or '#000000')) }};
            padding: 15px;
        }

        .table-start table tr.item {
            background-color: #DEDEDE;
        }

        .table-start table tr.item.odd {
            background-color: #CAC9CE;
        }

        .table-start table tr.item td {
            padding: 15px;
            color: #333333;
            font-size: 12px;
        }

        .table-start table tr.line-end {
            background-color: {{ $color or '#000000' }};
            border-color: {{ $color or '#000000' }};
        }

        .table-start table tr.line-end td {
            height: 5px;
        }

        .table-starter-box {
            height: 405px;
        }

        .table-start table tr.total-line td {
            padding-top: 9px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
            line-height: 17px;
            font-size: 17px;
            color: #3d3d3d;
        }

        .table-start table tr.total-line td.field {
            padding-right: 20px;
            font-size: 17px;
        }

        .table-start table tr.total-line .grand-total {
            color: {{ \Newestapps\Report\Helpers\Color::getContrastColor(($color or '#000000')) }};
            background-color: {{ $color or '#000000' }};
            padding-top: 15px;
            padding-bottom: 15px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
        }

    </style>
@endsection

@section('content')

    <div class="logo">
        @if(isset($logoUrl) && !empty($logoUrl))
            <img src="{{ $logoUrl }}" width="240">
        @endif
    </div>

    <div class="title">
        FATURA
    </div>

    @if(isset($customer) && is_array($customer))
        <div class="to">
            Fatura para
            <br>
            <b>{{ $customer['name'] }}</b>
            <br>
            <span class="email">{{ $customer['email'] }}</span>
            <br>
            <span>{{ $customer['address'] }}</span>
        </div>
    @endif

    <div class="invoice-info">
        @if(isset($createdAt) && !empty($createdAt) && ($createdAt instanceof DateTime))
            Lançamento: #{{ $createdAt->format('d/m/Y') }}
            <br>
        @endif

        @if(isset($finishedAt) && !empty($finishedAt) && ($finishedAt instanceof DateTime))
            Liberação: #{{ $finishedAt->format('d/m/Y') }}
            <br>
        @endif

        @if(isset($reference) && !empty($reference))
            Referência: #{{ $reference }}
            <br>
        @endif

        @if(isset($customer) && is_array($customer) && isset($customer['id']))
            Código pessoal: #{{ $customer['id'] }}
        @endif

    </div>

    <div class="total-due">

        <div class="value-box">
            <div class="line1">Total:</div>
            <div class="line2">
                R$ {{ number_format($totalAmount + $extraFees - $discounts, 2, ',', '.') }}
            </div>
        </div>

    </div>

    <div class="table-start">
        <div class="table-starter-box"></div>

        <table cellpadding="0" cellspacing="0">
            <tr class="head">
                <th width="20" style="text-align: right">#</th>
                <th width="210">Descrição</th>
                <th width="40">Qtd.</th>
                <th width="60" style="text-align: left">Valor</th>
                <th width="65" style="text-align: left">Total</th>
            </tr>

            @foreach($items as $index => $item)
                <tr class="item @if(($index % 2) == 1) odd @endif ">
                    <td style="text-align: right">{{ $item['id'] }}</td>
                    <td style="text-align: left">{{ $item['name'] }}</td>
                    <td style="text-align: center">{{ number_format($item['quantity'], 2, ',', '.') }}</td>
                    <td style="text-align: left">R$ {{ number_format($item['value'], 2, ',', '.') }}</td>
                    <td style="text-align: left">
                        R$ {{ number_format($item['value'] * $item['quantity'], 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach

            <tr class="line-end">
                <td colspan="5"></td>
            </tr>

            <tr>
                <td colspan="5" style="height: 15px;"></td>
            </tr>

            <tr>
                <td colspan="2" valign="top">

                    <div style="padding-left:45px;padding-right: 25px;padding-top:8px;">

                        <h4 style="font-size:15px;font-weight: bold;padding:0;margin:0;">Observações</h4>

                        <p style="font-size:11px;color:#666666;line-height: 16px;">
                            {!! $notes !!}
                        </p>

                    </div>

                </td>
                <td colspan="3">

                    <table style="width:365px;" cellspacing="0" cellpadding="0">
                        <tr class="total-line" valign="middle">
                            <td style="text-align: right; width:100px;" class="field">Subtotal:</td>
                            <td class="value" valign="middle">R$ {{ number_format($totalAmount, 2, ',', '.') }}</td>
                        </tr>

                        <tr class="total-line">
                            <td style="text-align: right;" class="field" valign="middle">Taxas</td>
                            <td class="value" valign="middle">R$ {{ number_format($extraFees, 2, ',', '.') }}</td>
                        </tr>

                        <tr class="total-line">
                            <td style="text-align: right;padding-bottom: 14px;" class="field" valign="middle">
                                Descontos:
                            </td>
                            <td class="value" valign="middle" style="padding-bottom: 14px;">
                                (R$ {{ number_format($discounts, 2, ',', '.') }})
                            </td>
                        </tr>

                        <tr class="total-line">
                            <td style="text-align: right;" class="field grand-total" valign="middle">Total:</td>
                            <td class="value grand-total" valign="middle" style="font-weight: bold;">
                                R$ {{ number_format($totalAmount + $extraFees - $discounts, 2, ',', '.') }}</td>
                        </tr>
                    </table>

                </td>
            </tr>

            <tr>
                <td colspan="5" style="height: 15px;"></td>
            </tr>

            @if(isset($company) && is_array($company))

                <tr>
                    <td colspan="5" style="padding: 45px;text-align: center;font-size: 13px;color:#666666;">

                        @if(isset($company['name']) && !empty(trim($company['name'])))
                            <div style="font-weight: bold;text-transform: uppercase;padding-bottom:5px;">{{ $company['name'] }}</div>
                        @endif

                        @if(isset($company['website']) && !empty(trim($company['website'])))
                            {{ $company['website'] }}

                            <span style="padding-left:6px; padding-right:6px; color: {{ $color or '#000000' }}"> • </span>
                        @endif

                        @if(isset($company['phone']) && !empty(trim($company['phone'])))
                            {{ $company['phone'] }}
                        @endif

                    </td>
                </tr>

            @endif


        </table>
    </div>

    <footer>
        @if($attachBarcode === true)
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td align="center" valign="middle">
                        <?php
                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                        echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($reference,
                                $barcodeType)).'">';
                        ?>
                    </td>
                </tr>
            </table>
        @endif
    </footer>

@endsection