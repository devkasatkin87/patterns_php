<?php

abstract class Unit
{
    public function getComposite()
    {
        return null;
    }
    abstract function getStrength();
}

abstract class CompositeUnit extends Unit
{
    private $units = [];
    
    public function getComposite()
    {
        return $this;
    }
    
    public function getUnits()
    {
        return $this->units;
    }
    
    public function removeUnit(Unit $unit)
    {
        $this->units = array_udiff($this->units, [$unit], function($a, $b) {
                    return ($a === $b) ? 0 : 1;
            
        });
    }
    
    public function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true)){
            return;
        }
        $this->units[] = $unit;
    }
}

class Archer extends Unit
{
    private $strength;
    
    public function __construct()
    {
        $this->strength = 10;
    }
    
    public function getStrength()
    {
        return $this->strength;
    }
}

class Slinger extends Unit
{
    private $strength;
    
    public function __construct()
    {
        $this->strength = 5;
    }
    
    public function getStrength()
    {
        return $this->strength;
    }
}

class Pikeman extends Unit
{
    private $strength;
    
    public function __construct()
    {
        $this->strength = 12;
    }
    
    public function getStrength()
    {
        return $this->strength;
    }
}

class Army extends CompositeUnit
{
    public function getStrength()
    {
        $ret = 0;
        foreach (parent::getUnits() as $unit){
            $ret += $unit->getStrength();
        }
        return $ret;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new Pikeman());
$main_army->addUnit(new Pikeman());
$main_army->addUnit(new Slinger());

$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

print_r($main_army->getStrength().PHP_EOL);
print_r($sub_army->getStrength().PHP_EOL);

var_dump($main_army);
var_dump($sub_army);