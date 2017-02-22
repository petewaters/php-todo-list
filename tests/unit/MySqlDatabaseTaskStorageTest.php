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
		$task = $this->storage->get(0);

		$this->assertEquals(0, $task->getId());
	}

	/** @test **/
	public function that_we_can_store_a_task_return_the_id_and_delete_a_task()
	{
		$date = new DateTime('now');

		$task = new Task;
		$task->setDescription('Test');
		$task->setDue($date);
		$task->setComplete(false);

		$lastStoredTaskId = $this->storage->store($task)->getId();

		$this->assertCount(3, $this->storage->all());

		$this->storage->delete($lastStoredTaskId);

		$this->assertCount(2, $this->storage->all());
	}

	/** @test **/
	public function that_we_can_update_a_stored_task()
	{
		$task = $this->storage->get(0);

		// Store the values to revert the task back to its original state after test
		$original = clone($task);

		$task->setDescription('Updated description');
		$task->setComplete(true);

		$this->storage->update($task);

		$updatedTask = $this->storage->get(0);

		$this->assertEquals($updatedTask->getDescription(), 'Updated description');
		$this->assertEquals($updatedTask->getComplete(), true);

		// Revert back to original state
		$this->storage->update($original);
	}
}