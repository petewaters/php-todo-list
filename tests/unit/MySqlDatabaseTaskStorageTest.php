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
}