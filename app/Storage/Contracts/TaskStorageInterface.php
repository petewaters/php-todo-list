<?php

namespace Todo\Storage\Contracts;

interface TaskStorageInterface
{
	public function store(Task $task);
	public function update(Task $tasks);
	public function get(int $id);
	public function all();
}