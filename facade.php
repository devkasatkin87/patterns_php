<?php

class Product
{
    
}

class ManageProduct extends Product
{
    public static function calcPrice(Product $product)
    {
        $newPrice = $product->getPrice() * 0.9;
        print "Calculating price...{$newPrice}\n";
    }
    
    public static function Sale(Product $product)
    {
        print "{$product->getName()} was sold...\n";
    }
}

class ProductEntity extends Product
{
    public function getName()
    {
        return "Car";
    }
    
    public function getPrice()
    {
        return 1000;
    }
}

class ProductFacade
{
    private $product;
    
    public function __construct(Product $product)
    {
        $this->product = $product;    
        $this->manage();
    }
    
    public function manage()
    {
        ManageProduct::calcPrice($this->product);
        ManageProduct::Sale($this->product);
    }
}

$product1 = new ProductEntity();
$facade = new ProductFacade($product1);