<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>{{ config('app.name', 'Pershop') }}</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="{{ asset('css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=4.1.0') }}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        @include('layouts.lsidebar')
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        @include('layouts.rsidebar')
        <!--右侧部分结束-->
        
        
    </div>

    <!-- 全局js -->
    <script src="{{ asset('js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js?v=3.3.6') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/layer/layer.min.js') }}"></script>

    <!-- 自定义js -->
    <script src="{{ asset('js/hplus.js?v=4.1.0') }}"></script>
    <script type="text/javascript" src="{{ asset('js/contabs.js') }}"></script>

    <!-- 第三方插件 -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    
</body>

</html>
