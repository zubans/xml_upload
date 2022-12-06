<?php

namespace App\Tests;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCategory()
    {
        $category = new Category();
        $category->setName('one');

        $category->getName();
        $category->getId();

        $this->assertTrue(true);
    }

}
