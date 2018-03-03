<html>
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <style>

        /*header {*/
        /*position: fixed;*/
        /*top: -60px;*/
        /*left: 0px;*/
        /*right: 0px;*/
        /*background-color: lightblue;*/
        /*height: 50px;*/
        /*}*/

        /*footer {*/
        /*position: fixed;*/
        /*bottom: -60px;*/
        /*left: 0px;*/
        /*right: 0px;*/
        /*background-color: lightblue;*/
        /*height: 50px;*/
        /*}*/

        .page-break {
            page-break-after: always;
        }

        .page-break:last-child {
            page-break-after: never;
        }

        body {
            font-family: sans-serif, Verdana, arial;
            font-size: 12px;
        @if(isset($bodyStyle) && is_array($bodyStyle) && count($bodyStyle) > 0)
        @foreach($bodyStyle as $attr => $value)
              {{ $attr }}: {{ $value }};
        @endforeach
        @endif


        }

        @if(isset($pageBackground) && !empty(trim($pageBackground)))

        @page {
            margin: 0;
        }

        body {
            width: 100%;
            height: 100%;
            padding-top: {{ $marginTop or '50px' }};
            padding-bottom: {{ $marginBottom or '50px' }};
            padding-left: {{ $marginLeft or '50px' }};
            padding-right: {{ $marginRight or '50px' }};
            background: {{ $pageBackground or '' }};
        }

        @else

            @page {
            margin-top: {{ $marginTop or '50px' }};
            margin-bottom: {{ $marginBottom or '50px' }};
            margin-left: {{ $marginLeft or '50px' }};
            margin-right: {{ $marginRight or '50px' }};
        }

        @endif

    </style>

    @yield('style')

</head>
<body style="display: block;">

@yield('content')

</body>
</html>