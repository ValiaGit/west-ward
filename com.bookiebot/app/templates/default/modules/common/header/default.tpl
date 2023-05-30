<!DOCTYPE html>
<html>
<head>
    <title>BetPlanet</title>
    <meta charset="utf8"/>

    <!--<link rel="stylesheet" href="{{$THEME}}/css/font-awesome.min.css">-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{$THEME}}/css/application.css?v={{$cache_version}}"/>
    <link rel="stylesheet" href="{{$THEME}}/css/override.css?v=4"/>

    <link rel="stylesheet" href="{{$THEME}}/intro/introjs.css?v=4"/>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
    <meta name="google-site-verification" content="NnomOGdhIQo0_WrgCVVR2bCkslNRJcMN_I9O8AeFUgY" />
    <meta name="google-site-verification" content="uEXOaH024Zn0ICQ-17VFUnKLyORJlTjvhGiXmDsBnkM" />

    <meta name="cubits-verify" content="-DDv4t7i27caDkV2fL7dog">

<link rel="shortcut icon" href="{{$THEME}}/images/touch-icons/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" sizes="57x57" href="{{$THEME}}/images/touch-icons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{$THEME}}/images/touch-icons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{$THEME}}/images/touch-icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{$THEME}}/images/touch-icons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{$THEME}}/images/touch-icons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{$THEME}}/images/touch-icons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{$THEME}}/images/touch-icons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{$THEME}}/images/touch-icons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{$THEME}}/images/touch-icons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="{{$THEME}}/images/touch-icons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="{{$THEME}}/images/touch-icons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="{{$THEME}}/images/touch-icons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="{{$THEME}}/images/touch-icons/android-chrome-192x192.png" sizes="192x192">
<meta name="msapplication-square70x70logo" content="{{$THEME}}/images/touch-icons/smalltile.png" />
<meta name="msapplication-square150x150logo" content="{{$THEME}}/images/touch-icons/mediumtile.png" />
<meta name="msapplication-wide310x150logo" content="{{$THEME}}/images/touch-icons/widetile.png" />
<meta name="msapplication-square310x310logo" content="{{$THEME}}/images/touch-icons/largetile.png" />



    <script>
        var api_url = '{{$api_url}}';
        var cur_lang = '{{$cur_lang}}';
        var bc_lang = '{{$config.langs.$cur_lang.bConstructCode}}';
        var base_href = '{{$base_href}}';
        var needs_authentication = '{{$Data.needs_authentication}}';
        var request_uri = '{{$Data.request_uri}}';
    </script>





    <!-- Some Utility Functions -->

</head>

{{include file='view/includes/Popups/registration.tpl'}}
{{include file='view/includes/popups.tpl'}}