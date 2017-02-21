<?php

namespace Todo\Storage\Contracts;

use Todo\Models\Task;

interface TaskStorageInterface
{
	public function store(Task $task);
	public function update(Task $tasks);
	public function get(int $id);
	public function all();
}