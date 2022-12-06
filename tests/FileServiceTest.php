<?php

namespace App\Tests;

use App\Services\FileService;
use Symfony\Component\HttpFoundation\Request;

class FileServiceTest extends Test
{
    public function testCategory()
    {
        (new Request())->files->add(['Test.php']);
        $fileService = (new FileService())->readFile(new Request(), $this->getRepositoryCreateMock());
        $this->assertTrue(true);
    }

}
