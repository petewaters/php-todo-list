<?php

namespace Todo\Models;

use DateTime;

class Task 
{
	protected $id;
	protected $complete = false;
	protected $description;
	protected $due;

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setComplete($complete = true)
	{
		$this->complete = $complete;
	}

	public function getComplete()
	{
		return (bool) $this->complete;
	}

	public function setDue(DateTime $due)
	{
		$this->due = $due;
	}

	public function getDue()
	{
		if (!$this->due instanceof DateTime) {
			return new DateTime($this->due);
		}

		return $this->due;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}
}