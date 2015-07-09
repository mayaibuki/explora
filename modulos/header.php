
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="explora">
<link rel="alternate" hreflang="es" href="http://explora.life/" />
    
<!--favicon-->
<link rel=icon href=/_img_icons/favicon16x16.png sizes="16x16" type="image/png">
<link rel=icon href=/_img_icons/windows48x48.ico sizes="32x32 48x48" type="image/vnd.microsoft.icon">
<link rel=icon href=/_img_icons/mac.icns sizes="128x128 512x512 8192x8192 32768x32768">
<link rel=icon href=/_img_icons/iphone.png sizes="57x57" type="image/png">
<link rel=icon href=/_img_icons/gnome.svg sizes="any" type="image/svg+xml">

<!-- Bootstrap Core CSS -->
<link href="/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="/css/explora.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,700,300italic,700italic' rel='stylesheet' type='text/css'>

<!-- animate.css -->
<link rel="stylesheet" href="/css/animate.css">

<!-- Mailchimp CSS -->
<link href="/css/mailchimp.css" rel="stylesheet" type="text/css">



<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!--{% block meta %}-->
    <meta name="description" content="{{ config.default_site_meta_description }}">
    <!--FB Opengraph-->
    <meta property="og:title" content="{{ config.site_title }}"/>
    <meta property="og:site_name" content="{{ config.site_title }}"/>
    <meta property="og:description" content="{{ config.default_site_meta_description }}"/>
    <!-- Twitter-->
    <meta name="twitter:card" content="summary_text-price_image">
    <meta name="twitter:site" content="{{ config.twitter_handle }}">
    <meta name="twitter:creator" content="{{ config.twitter_handle }}">
    <meta name="twitter:title" content="{{ config.site_title }}">
    <meta name="twitter:description" content="{{ config.default_site_meta_description }}">
<!--{% endblock %}-->