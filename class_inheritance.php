<?php

// Base class for shapes
class Shape {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    // Method to calculate area (to be implemented by subclasses)
    public function area() {
        return 0;
    }

    public function getName() {
        return $this->name;
    }
}

// Circle class inheriting from Shape
class Circle extends Shape {
    private $radius;

    public function __construct($radius) {
        parent::__construct("Circle");
        $this->radius = $radius;
    }

    // Implementing area calculation for Circle
    public function area() {
        return pi() * pow($this->radius, 2);
    }
}

// Rectangle class inheriting from Shape
class Rectangle extends Shape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        parent::__construct("Rectangle");
        $this->width = $width;
        $this->height = $height;
    }

    // Implementing area calculation for Rectangle
    public function area() {
        return $this->width * $this->height;
    }
}

// Example usage:
$circle = new Circle(5);
echo $circle->getName() . " Area: " . $circle->area() . "\n";

$rectangle = new Rectangle(4, 6);
echo $rectangle->getName() . " Area: " . $rectangle->area() . "\n";

?>
