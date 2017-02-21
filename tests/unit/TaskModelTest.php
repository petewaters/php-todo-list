<?php 

use PHPUnit\Framework\TestCase;
use Todo\Models\Task;
use DateTime;
use Reflector;

class CalculatorTest extends TestCase 
{
	protected $task;

	public function setUp()
	{
		$this->task = new Task;
	}

	/** @test **/
	public function that_we_can_get_the_description()
	{
		$this->task->setDescription('Some description');

		$this->assertEquals($this->task->getDescription(), 'Some description');
	} 

	/** @test **/
	public function that_we_can_set_a_task_as_complete()
	{
		$this->task->setComplete();

		$this->assertEquals($this->task->getComplete(), true);
	}

	/** @test **/
	public function that_we_can_set_a_task_as_incomplete()
	{
		// Set as true as set as false initially
		$this->task->setComplete(true);
		$this->task->setComplete(false);

		$this->assertEquals($this->task->getComplete(), false);
	}

	/** @test **/
	public function that_we_can_get_a_due_date()
	{
		$date = new DateTime('now');
		$this->task->setDue($date);

		$this->assertEquals($this->task->getDue(), $date);
	}

	/** @test **/
	public function that_we_can_get_the_id_of_a_task()
	{
		$this->task->setId(1);

		$this->assertEquals($this->task->getId(), 1);
	}
}