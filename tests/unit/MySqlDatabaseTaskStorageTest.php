<?php

use PHPUnit\Framework\TestCase;
use Todo\Models\Task;
use Todo\Storage\MySqlDatabaseTaskStorage;

class MySqlDatabaseTaskStorageTest extends TestCase 
{
	protected $db;
	protected $storage;

	public function setUp()
	{
		$this->db = new PDO('mysql:host=127.0.0.1;dbname=todo', 'root', '');
		$this->storage = new MySqlDatabaseTaskStorage($this->db);
	}

	/** @test **/
	public function that_we_can_retrieve_all_tasks_from_the_database()
	{
		$this->assertCount(2, $this->storage->all());
	}

	/** @test **/
	public function that_we_can_retrieve_a_task_from_the_database_by_id()
	{
		$this->assertCount(1, $this->storage->get(1));
	}

	/** @test **/
	public function that_we_can_store_a_task_return_the_id_and_delete_a_task()
	{
		$date = new DateTime('now');

		$task = new Task;
		$task->setDescription('Test');
		$task->setDue($date);
		$task->setComplete(false);

		$lastStoredTaskId = $this->storage->store($task);

		$this->assertCount(3, $this->storage->all());

		$this->storage->delete($lastStoredTaskId);

		$this->assertCount(2, $this->storage->all());
	}
}