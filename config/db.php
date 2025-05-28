<?php

$host = env('MYSQL_HOST');
$name = env('MYSQL_DATABASE');
$username = env('MYSQL_USER');
$password = env('MYSQL_PASSWORD','');

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$host};dbname={$name}",
    'username' => "{$username}",
    'password' => "{$password}",
    'charset' => 'utf8mb4',
];
