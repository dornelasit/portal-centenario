<?php 
    header("Content-type: text/html; charset=UTF-8");
    require_once 'classes/application_config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta content='yes' name='apple-mobile-web-app-capable' />
        <meta content='yes' name='mobile-web-app-capable' />
        <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
        <meta name="theme-color" content="black">
        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title><?php echo PORTAL_NAME ?></title>
        <base href=".">
        <link href="css/global.css?<?php echo APP_VERSION ?>" rel="stylesheet" type="text/css">
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/fontawesome-free/css/all.min.css">
        <link href="css/bootstrap.min.css?<?php echo APP_VERSION ?>" rel="stylesheet" media="screen">
        <link href="css/stylesheet.css?<?php echo APP_VERSION ?>" rel="stylesheet">
        <link href="css/jquery-ui.css?<?php echo APP_VERSION ?>" rel="stylesheet">
        <link href="css/magnific-popup.css?<?php echo APP_VERSION ?>" type="text/css" rel="stylesheet" media="screen">
        <link href="css/swiper.min.css?<?php echo APP_VERSION ?>" type="text/css" rel="stylesheet" media="screen">
        <link href="css/opencart.css?<?php echo APP_VERSION ?>" type="text/css" rel="stylesheet" media="screen">
        <script src="js/jquery.min.js.download?<?php echo APP_VERSION ?>"></script>
        <script src="js/jquery.mask.min.js?<?php echo APP_VERSION ?>"></script>
        <script src="js/bootstrap.min.js.download?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/jquery.magnific-popup.min.js.download?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/swiper.jquery.js.download?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/common.js.download?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/jquery-ui.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/alert.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/application.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/lote-min.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/receita-min.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/despesa-min.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/caixa-min.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/usuario.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/servico-material-min.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>
        <script src="js/receita-benfeitoria.js?<?php echo APP_VERSION ?>" type="text/javascript"></script>        
        <link href="img/favicon.ico" rel="icon">
    </head>
    <body>

    <noscript>Por favor, habilite o JavaScript para utilizar a aplicação.</noscript>

    <?php include_once 'top-nav.php'; ?>
    <?php include_once 'header-nav.php'; ?>
    <?php include_once 'category-nav.php'; ?>

