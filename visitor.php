<?php

abstract class Unit
{
    protected $depth = 0;
    
    public function getComposite()
    {
        return null;
    }
    
    public function accept(ArmyVisitor $visitor)
    {
        $method = "visit" . get_class($this);
        $visitor->$method($this);
    }
    
    public function getDepth()
    {
        return $this->depth;
    }
    
    public function setDepth($depth)
    {
        $this->depth = $depth;
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
        foreach ($this->units as $thisunit)
        {
            if ($unit == $thisunit){
                return;
            }    
        }
        $unit->setDepth($this->depth + 1);
        $this->units[] = $unit;
    }
    
    public function accept(ArmyVisitor $visitor)
    {
        $method = "visit" . get_class($this);
        $visitor->$method($this);
        foreach ($this->units as $thisunit)
        {
            $thisunit->accept($visitor);
        }
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

abstract class ArmyVisitor
{
    abstract function visit(Unit $node);
    
    public function visitArcher(Archer $node)
    {
        $this->visit($node);
    }
    
    public function visitPikeman(Pikeman $node)
    {
        $this->visit($node);
    }
    
    public function visitSlinger(Slinger $node)
    {
        $this->visit($node);
    }
    
    public function visitArmy(Army $node)
    {
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor
{
    private $text = "";
    
    public function visit(Unit $node)
    {
        $txt = "";
        $pad = 4 * $node->getDepth();
        $txt .= sprintf("%{$pad}s" , "");
        $txt .= get_class($node) . ": ";
        $txt .= "Fire Power: " . $node->getStrength() . "\n";
        $this->text  .= $txt;
    }
    
    public function getText()
    {
        return $this->text;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new Pikeman());
$main_army->addUnit(new Pikeman());
$main_army->addUnit(new Slinger());

$textDump = new TextDumpArmyVisitor();
$main_army->accept($textDump);
print $textDump->getText();

$sub_army = new Army();
$sub_army->addUnit(new Pikeman());
$sub_army->addUnit(new Pikeman());
$sub_army->addUnit(new Slinger());

$textDump2 = new TextDumpArmyVisitor();
$sub_army->accept($textDump2);
print $textDump2->getText();

$general_army = new Army();
$general_army->addUnit($main_army);
$general_army->addUnit($sub_army);
$textDump3 = new TextDumpArmyVisitor();
$general_army->accept($textDump3);
print $textDump3->getText();