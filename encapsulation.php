<?php

class Employee {

    private $name;
    private $position;
    private $salary;

   
    public function __construct($name, $position, $salary) {
        $this->name = $name;
        $this->position = $position;
        $this->setSalary($salary); // Using setter to initialize salary
    }

 
    public function getName() {
        return $this->name;
    }


    public function getPosition() {
        return $this->position;
    }


    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        if ($salary < 0) {
            throw new Exception("Salary cannot be negative.");
        }
        $this->salary = $salary;
    }


    public function giveRaise($amount) {
        $this->setSalary($this->salary + $amount);
    }

    // Method to display employee information
    public function displayEmployeeInfo() {
        return "Name: " . $this->getName() . 
               "\nPosition: " . $this->getPosition() . 
               "\nSalary: $" . $this->getSalary();
    }
}



try {
   
    $employee = new Employee("John Doe", "Software Engineer", 50000);

   
    echo $employee->displayEmployeeInfo() . "\n";


    $employee->giveRaise(5000);
    echo "After raise:\n" . $employee->displayEmployeeInfo() . "\n";


} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
