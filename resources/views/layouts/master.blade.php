<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EARTHCUTTER</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    {{--<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=1hfCQtjMGprIZn7DxUQcCdt57k270GLl"></script>--}}

    <link rel="stylesheet" href="/css/app.css">
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden!important;
        }

        #app {
            width: 100%;
            height: 100%;
        }
        /* 设置滚动条的样式 */

        .slim_scrollbar::-webkit-scrollbar {
            width: 3px;
        }

        .slim_scrollbar::-webkit-scrollbar {
            height: 3px;
        }
        /* 滚动槽 */

        .slim_scrollbar::-webkit-scrollbar-track {
            background-color: #eee;
        }
        /* 滚动条滑块 */

        .slim_scrollbar::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: #aaa;
        }

        .slim_scrollbar::-webkit-scrollbar-thumb:window-inactive {
            background: #ddd;
        }

    </style>
</head>
<body>

<div id="app">
    <app></app>
</div>
<script src="/js/app.js"></script>
</body>
</html>
