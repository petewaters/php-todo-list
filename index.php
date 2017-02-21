<?php

require 'vendor/autoload.php';

session_start();

try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=todo', 'root', '');
} catch (PDOException $e) {
	echo 'Error establishing connection to database.';
}

$tasks = $db->prepare("SELECT * FROM tasks");
$tasks->setFetchMode(PDO::FETCH_CLASS, Task::class);
$tasks->execute();

var_dump($tasks->fetchAll());