<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <link rel="icon" type="image/png" href="<?= Roots\Sage\Assets\asset_path('images/favicon.png'); ?>">

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-61894369-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-61894369-1');
  </script>

</head>
