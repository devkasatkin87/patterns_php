<?php 

class Animal
{
    public $quantity = 10;
}

abstract class Sea
{
    
}
class EarthSea extends Sea
{
    private $depth = 10;
}
class MarsSea extends Sea
{
    private $depth = 40;
}

abstract class Plains
{
    private $visibility = 40;
}
class EarthPlains extends Plains
{
    public $visibility = 100;
}
class MarsPlains extends Plains
{
    
}

abstract class Forest
{
    
}
class EarthForest extends Forest
{
    public $animals;
    
    public function __construct(Animal $animals)
    {
        $this->animals = $animals;
    }
    
    public function __clone()
    {
        $this->animals = clone $this->animals;
    }
}
class MarsForest extends Forest
{
    
}

class TerrainFactory
{
    private $sea;
    private $plains;
    private $forest;
    
    public function __construct(Sea $sea, Plains $plains, Forest $forest)
    {
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }
    
    public function getSea()
    {
        return clone $this->sea;
    }
    
    public function getPlains()
    {
        return clone $this->plains;
    }
    
    public function getForest()
    {
        return clone $this->forest;
    }
}
$fox = new Animal();
$factory = new TerrainFactory(new MarsSea(), new EarthPlains(), new EarthForest($fox));
//print_r($factory);

//print_r($marsSea = $factory->getSea());
//print_r($earthPlains = $factory->getPlains());
print_r($earthForest = $factory->getForest());
$fox->quantity = 20;
print_r($earthForest);