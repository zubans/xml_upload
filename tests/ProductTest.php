<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCategory()
    {
        $product = new Product();
        $product->setName('one');

        $name = $product->getName();
        $this->assertEquals('one', $name);

        $product->setCategoryId(new Category());
        $catId = $product->getCategoryId();

        $product->setWeigth('123');
        $weight = $product->getWeigth();

        $product->setWeightPrecision('1');
        $press = $product->getWeightPrecision();

        $product->setDescription('123');
        $desc = $product->getDescription();

        $id = $product->getId();
        $this->assertTrue(true);
    }

}
