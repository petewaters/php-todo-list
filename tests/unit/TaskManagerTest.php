<?php

use PHPUnit\Framework\TestCase;
use Todo\Models\Task;
use Todo\TaskManager;
use Todo\Storage\MySqlDatabaseTaskStorage;

class TaskManagerTest extends TestCase 
{
	protected $db;
	protected $manager;

	public function setUp()
	{
		$this->db = new PDO('mysql:host=127.0.0.1;dbname=todo', 'root', '');
		$this->manager = new TaskManager(new MySqlDatabaseTaskStorage($this->db));
	}

	/** @test **/
	public function that_the_task_manager_can_add_and_delete_a_task()
	{
		$date = new DateTime('now');

		$task = new Task;
		$task->setDescription('Test');
		$task->setDue($date);
		$task->setComplete(false);

		$lastStoredTaskId = $this->manager->addTask($task)->getId();

		$this->assertCount(3, $this->manager->getTasks());

		$this->manager->deleteTask($lastStoredTaskId);

		$this->assertCount(2, $this->manager->getTasks());
	}

	/** @test **/
	public function that_the_task_manager_can_update_a_task()
	{
		$task = $this->manager->getTask(0);

		// Store the values to revert the task back to its original state after test
		$original = clone($task);

		$task->setDescription('Updated description');
		$task->setComplete(true);

		$this->manager->updateTask($task);

		$updatedTask = $this->manager->getTask(0);

		$this->assertEquals($updatedTask->getDescription(), 'Updated description');
		$this->assertEquals($updatedTask->getComplete(), true);

		// Revert back to original state
		$this->manager->updateTask($original);
	}

	/** @test **/
	public function that_the_task_manager_can_retrieve_a_single_task()
	{
		$task = $this->manager->getTask(0);

		$this->assertEquals(0, $task->getId());
	}

	/** @test **/
	public function that_the_task_manager_can_retrieve_all_tasks()
	{
		$this->assertCount(2, $this->manager->getTasks());
	}
}