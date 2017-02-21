<?php

use Todo\Models\Task;
use Todo\Storage\MySqlDatabaseTaskStorage;

require 'vendor/autoload.php';

session_start();

try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=todo', 'root', '');
} catch (PDOException $e) {
	echo 'Error establishing connection to database.';
}

$storage = new MySqlDatabaseTaskStorage($db);

$task = new Task;
$task->setDescription('Test');
$task->setDue(new DateTime('+2 days'));

$storage->store($task);