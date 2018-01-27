<head>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" href="/components/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/components/trumbowyg/dist/ui/trumbowyg.css">
  <link rel="stylesheet" href="/mystyle.css">
  <script src="/components/jquery/dist/jquery.js"></script>
  <script src="/components/bootstrap/dist/js/bootstrap.js"></script>
  <script src="/js/script.js"></script>
  <script>
  <?php 
  //print php GET vars for javascript
  $get_vars = new PrintGetVars();
  echo $get_vars;
  ?>
  </script>
  <title><?php echo $page_title; ?></title>
</head>