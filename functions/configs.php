<?php
    $configs = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/configs.ini');

    foreach ($configs as $configKey => $configValue) {
        define($configKey, $configValue);
    }
