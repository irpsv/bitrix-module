<?php

/**
 * @var CMain $APPLICATION
 */

include __DIR__ .'/include/head.php';

?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <? $APPLICATION->ShowTitle(); ?>
    </title>
    <?php
    $APPLICATION->ShowHead();
    include __DIR__ .'/include/head-counters.php';
    ?>
</head>
<body>
    <?php
    $APPLICATION->ShowPanel();
    ?>
    