<?php
if(session_status() != PHP_SESSION_ACTIVE)
    session_start();
?>
<head>
    <title><?php echo $html_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/bootstrap-5.2.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/bootstrap-icons-1.10.3/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/styles/login.css">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/styles/nav.css">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/styles/serchbar.css">
    <link rel="stylesheet" href="<?php echo URL ?>application/libs/styles/custom.css">
    <script href="<?php echo URL ?>application/libs/bootstrap-5.2.3-dist/js/bootstrap.js"></script>
    <script href="<?php echo URL ?>application/libs/jQuery_3.7.1.js"></script>
</head>
<body>
<div class="content">
    <?php if(isset($_SESSION[S_IS_LOGGED]) && $_SESSION[S_IS_LOGGED]): ?>
        <input class="menu-icon d-print-none" type="checkbox" id="menu-icon" name="menu-icon"/>
        <label for="menu-icon" class="d-print-none"></label>
        <nav class="nav d-print-none">
            <ul class="pt-5">
                <li><a href="<?php echo URL ?>">Home</a></li>
                <li><a href="<?php echo URL . 'songs/'?>">Songs</a></li>
                <?php if($_SESSION[S_USER]->getIsAdmin()): ?>
                    <li><a href="<?php echo URL . 'administration'?>">Administration</a></li>
                <?php endif; ?>
                <li><a href="<?php echo URL . 'account/logout'?>">Logout</a></li>
            </ul>
        </nav>
    <?php endif; ?>

