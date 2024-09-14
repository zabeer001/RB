<?php

class Employee {
    // Private properties for encapsulation
    private $name;
    private $position;
    private $salary;

    // Constructor to initialize the employee data
    public function __construct($name, $position, $salary) {
        $this->name = $name;
        $this->position = $position;
        $this->setSalary($salary); // Using setter to initialize salary
    }

    // Getter for name
    public function getName() {
        return $this->name;
    }

    // Getter for position
    public function getPosition() {
        return $this->position;
    }

    // Getter for salary (secure access)
    public function getSalary() {
        return $this->salary;
    }

    // Setter for salary (secure modification)
    public function setSalary($salary) {
        if ($salary < 0) {
            throw new Exception("Salary cannot be negative.");
        }
        $this->salary = $salary;
    }

    // Method to give a raise
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

// Example usage:

try {
    // Creating an Employee object
    $employee = new Employee("John Doe", "Software Engineer", 50000);

    // Displaying employee information
    echo $employee->displayEmployeeInfo() . "\n";

    // Giving a raise to the employee
    $employee->giveRaise(5000);
    echo "After raise:\n" . $employee->displayEmployeeInfo() . "\n";

    // Trying to set a negative salary (will throw an exception)
    // $employee->setSalary(-10000);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>
