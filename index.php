<?php

use Todo\Models\Task;
use Todo\TaskManager;
use Todo\Storage\MySqlDatabaseTaskStorage;

require 'vendor/autoload.php';

session_start();

try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=todo', 'root', '');
} catch (PDOException $e) {
	echo 'Error establishing connection to database.';
}

$manager = new TaskManager(new MySqlDatabaseTaskStorage($db));

