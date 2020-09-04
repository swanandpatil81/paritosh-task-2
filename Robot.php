<?php

ini_set('display_errors' , 1);

Class Robot{
	public $no_of_floor;
	public $area_of_floor;
	public $current_floor = 1;
	public $battery_charging_time = 20;
	public $battery_life_secs = 60;
	public $floor_shifting_time = 15;
	public $robot_speed_sqft_per_second = 100 / 10;
	public $total_seconds_happened = 0;
	public $battery_cycle_pivot = 1;
	public $start_cleaning_from = 0;
	public $end_cleaning_to = 0;

	public function pretty_print($statement){
		echo $statement."<br>";
	}

	public function show_current_time($seconds){
		date_default_timezone_set("Asia/Kolkata");
		$time = date("d/m/Y H:i:s a", time() + $seconds);
		return $time;
	} 

	public function calculate_robot_task($no_of_floor,$area_of_floor){

		$this -> no_of_floor = $no_of_floor;
		$this -> area_of_floor = $area_of_floor;

		while($this -> current_floor <= $this -> no_of_floor){

			$this -> pretty_print("Robot moving to Floor ".$this -> current_floor. ".. Wait for ".$this -> floor_shifting_time. " Sec [Time = ".$this -> show_current_time($this -> total_seconds_happened)."] ");

			$this -> total_seconds_happened += $this -> floor_shifting_time;

			$this -> pretty_print("Robot reached to Floor ".$this -> current_floor."           [Time = ".$this -> show_current_time($this -> total_seconds_happened)."]");
			

			echo $total_seconds_to_clean_floor = $this -> area_of_floor / $this -> robot_speed_sqft_per_second;
			echo $battery_charges_taken = round($total_seconds_to_clean_floor / $this -> battery_life_secs);

			while($this -> battery_cycle_pivot <= $battery_charges_taken){

				$this -> pretty_print("Floor ".$this -> current_floor." cleaning started at            [Time = ".$this -> show_current_time($this -> total_seconds_happened)."]");

				if($this -> current_floor == 1){
					$this -> start_cleaning_from = 0;
					$this -> end_cleaning_to = ($this -> area_of_floor / $battery_charges_taken);
				}else{
					$this -> start_cleaning_from = $this -> end_cleaning_to + 1;
					$this -> end_cleaning_to = $this -> end_cleaning_to + ($this -> area_of_floor / $battery_charges_taken);
				}

				$this -> pretty_print("Floor ".$this -> current_floor." START cleaning from ".$this -> start_cleaning_from." sqft           [Time = ".$this -> show_current_time($this -> total_seconds_happened)."]");

				$this -> total_seconds_happened += $this -> battery_life_secs;

				$this -> pretty_print("Floor ".$this -> current_floor." PAUSE cleaning on ".$this -> end_cleaning_to." sqft           [Time = ".$this -> show_current_time($this -> total_seconds_happened)."]");

				$this -> pretty_print("Robot charging started.. Wait for ".$this -> battery_charging_time. " Sec [Time = ".$this -> show_current_time($this -> total_seconds_happened)."] ");

				$this -> total_seconds_happened += $this -> battery_charging_time;

				$this -> pretty_print("Robot Fully charged.. [Time = ".$this -> show_current_time($this -> total_seconds_happened)."] ");

				$this -> battery_cycle_pivot++;

			}

			$this -> current_floor ++;
			$this -> battery_cycle_pivot = 1;

			$this -> pretty_print("==========================================================");

		}


	}
}

$robot_object = new Robot();

if( !isset($_GET['no_of_floor']) or empty($_GET['no_of_floor']) or !is_numeric($_GET['no_of_floor']) or !isset($_GET['area_of_floor']) or empty($_GET['area_of_floor']) or !is_numeric($_GET['area_of_floor'])){
	$robot_object -> pretty_print("?no_of_floor=2&area_of_floor=600");
	$robot_object -> pretty_print("no_of_floor = Required (Integer)");
	$robot_object -> pretty_print("area_of_floor = Required (Integer)");
}else{	
	$robot_object -> calculate_robot_task($_GET['no_of_floor'], $_GET['area_of_floor']);
}

?>