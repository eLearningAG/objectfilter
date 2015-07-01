<?php
class Product
{
    public $name;
    public $price;
    public $category;

    public function __construct($name, $price, $category)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
    }
}

$products = [new Product('Book #1', 30, 1), new Product('Book #2', 100, 1), new Product('CD #1', 25, 2), new Product('Book #3', 25, 1), new Product('CD #2', 15, 2)];

$filter = ELearningAG\ObjectFilter\Filter::create('filter[price]=20-30&filter[category]=1');

$filteredProducts = array_filter($products, $filter);

foreach($filteredProducts as $product) {
    echo $product->name.' - '.$product->price.PHP_EOL;
}
