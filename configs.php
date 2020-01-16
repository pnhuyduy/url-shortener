<?php
    $configs = parse_ini_file(__DIR__ . '/configs.ini');

    foreach ($configs as $configKey => $configValue) {
        define($configKey, $configValue);
    }
