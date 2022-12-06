<?php

namespace App\Tests;

use App\Controller\ProductController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends Test
{
    public function testCategory()
    {
        $this->createMock(ManagerRegistry::class);

        $prod = (new ProductController())->index($this->getRepositoryCreateMock(), new Request());

        $this->assertEquals($prod, 1);

        $this->assertTrue(true);
    }
}
