<?php


class PhpAdder{

	private $a;
	private $b;
	public $sum;

	public function __construct($a,$b){
		$this->a = $a;
		$this->b = $b;
	}
	
	public function add(){
		$this->sum = $this->a + $this->b;
	}
	
	public function display(){
		return $this->sum;
	}
}