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
		$query = $this->db->prepare("
			INSERT INTO tasks (description, due, complete)
			VALUES (:description, :due, :complete)
		");

		$query->execute($this->buildParams($task));

		return $this->get($this->db->lastInsertId());
	}

	public function update(Task $task)
	{
		$query = $this->db->prepare("
			UPDATE tasks 
			SET 
				description = :description,
				due = :due,
				complete = :complete
			WHERE id = :id
		");

		$query->execute($this->buildParams($task, [
			'id' => $task->getId(),
		]));

		return $this->get($task->getId());
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

		return $query->fetch();
	}

	public function delete(int $id)
	{
		$query = $this->db->prepare("
			DELETE FROM tasks 
			WHERE id = :id
		");

		$query->execute([
			'id' => $id,
		]);
	}

	public function all()
	{
		$query = $this->db->prepare("SELECT * FROM tasks");

		$query->setFetchMode(PDO::FETCH_CLASS, Task::class);

		$query->execute();

		return $query->fetchAll();
	}

	protected function buildParams(Task $task, array $additional = [])
	{
		return array_merge([
			'description' => $task->getDescription(),
			'due' => $task->getDue()->format('Y-m-d H:i:s'),
			'complete' => $task->getComplete() ? 1 : 0,
		], $additional);
	}
}