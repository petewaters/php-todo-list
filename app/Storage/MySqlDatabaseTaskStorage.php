<?php

namespace Todo\Storage;

use PDO;
use Todo\Models\Task;
use Todo\Storage\Contracts\TaskStorageInterface;

class MySqlDatabaseTaskStorage implements TaskStorageInterface
{
	protected $db;

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	public function store(Task $task)
	{
		
	}

	public function update(Task $task)
	{

	}

	public function get(int $id)
	{
		$query = $this->db->prepare("
			SELECT * FROM tasks
			WHERE id = :id
		");

		$query->setFetchMode(PDO::FETCH_CLASS, Task::class);

		$query->execute([
			'id' => $id,
		]);

		return $query->fetchAll();
	}

	public function all()
	{
		$query = $this->db->prepare("SELECT * FROM tasks");

		$query->setFetchMode(PDO::FETCH_CLASS, Task::class);

		$query->execute();

		return $query->fetchAll();
	}

}