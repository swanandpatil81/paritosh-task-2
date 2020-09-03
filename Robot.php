<?php

Class Robot{
	public $no_of_floor;
	public $area_of_floor;
	public $current_floor = 1;
	public $battery_charging_time = 20;
	public $battery_life_secs = 60;
	public $floor_shifting_time = 15;
	public $robot_speed_sqft_per_second = 100 / 10;
	public $total_seconds_happened = 0;
	public $battery_cycle_pivot = 0;

	public function __construct($no_of_floor,$area_of_floor){
		$this -> no_of_floor = $no_of_floor;
		$this -> area_of_floor = $area_of_floor;
	}

	public function pretty_print($statement){
		echo $statement."<br>";
	}

	public function show_current_time($seconds){
		$time = date("d/m/Y H:i:s a", time() + $seconds);
		return $time;
	} 

	public function calculate_robot_task(){

		while($this -> current_floor <= $this -> no_of_floor){

			$this -> pretty_print("Robot moving to Floor ".$this -> current_floor. ".. Wait for ".$this -> floor_shifting_time. " Sec [Time = ".$this -> show_current_time($this -> total_seconds_happened)."] ");

			$this -> total_seconds_happened += $this -> floor_shifting_time;

			$this -> pretty_print("Robot reached to Floor ".$this -> current_floor."           [Time = ".$this -> show_current_time($this -> total_seconds_happened)."]");

			$total_seconds_to_clean_floor = $this -> area_of_floor / $this -> robot_speed_sqft_per_second;
			$battery_charges_taken = $total_seconds_to_clean_floor / $this -> battery_life_secs;

			while($this -> battery_cycle_pivot < $battery_charges_taken){
				$this -> total_seconds_happened += $this -> battery_charging_time;

				$this -> pretty_print("Robot charging started.. Wait for ".$this -> battery_charging_time. " Sec [Time = ".$this -> show_current_time($this -> total_seconds_happened)."] ");

				$this -> battery_cycle_pivot++;
			}

			$this -> current_floor ++;
			$this -> battery_cycle_pivot = 0;
		}

	}
}


$robot_object = new Robot($_GET['no_of_floor'] , $_GET['area_of_floor']);
$robot_object -> calculate_robot_task();
?>