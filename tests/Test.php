<?php

namespace App\Tests;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    protected function getRepositoryCreateMock()
    {
        $author = (new Product())->setName('IvanovV');

        $serviceAuthorRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $serviceAuthorRepository->method('findFilteredQueryBuilder')->willReturn($author);

        $pag = $this->getMockBuilder(Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pag->method('getQuery')->willReturnSelf();

        $stub = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->onConsecutiveCalls($serviceAuthorRepository, $pag));

        return $stub;
    }


}
