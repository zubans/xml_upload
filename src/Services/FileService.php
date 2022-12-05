<?php

namespace App\Services;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use XMLReader;

class FileService
{
    /**
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return int
     */
    public function readFile(Request $request, ManagerRegistry $doctrine): int
    {
        $em = $doctrine->getManager();
        $file = $request->files->get('myfile');
        $reader = new XMLReader();
        $countElements = 0;

        if (empty($file) || !$reader->open($file)) //для работы с большими файлами нужно использовать или поток или генераторы.
        {
            throw new FileException($file);
        }

        while($reader->read())
        {
            if($reader->nodeType == XMLReader::ELEMENT) {
                $nodeName = $reader->name;
            }
            if ($nodeName == 'product') {
                $product = new Product();
                $arr = (new XmlService())->XmlToArray($reader->readOuterXml());

                //нужна проверка по составному индексу, чтобы не дублировать записи
                $product->setName($arr['name']);
                $product->setDescription($arr['description']);
                $parsedWeight = $this->parseWeight($arr['weight']);
                $product->setWeigth($parsedWeight[0]);
                $product->setWeightPrecision($parsedWeight[1]);

                $cat = $this->insertOrUpdateCategory($arr['category'], $doctrine);

                $product->setCategoryId($cat);
                $em->persist($cat);

                $em->persist($product);
                if ($countElements % 1000 === 0) {
                    $em->flush(); //Очень не оптимально. Данную обработку надо засовывать в стрименговый сервис, иначе на больших файлах не справляется

                }

                $countElements++;
                $reader->next('product');
            }
        }
        $reader->close();
        $em->flush();

        return $countElements;
    }

    /**
     * @param string $name
     * @param ManagerRegistry $mr
     * @return Category
     */
    protected function insertOrUpdateCategory(string $name, ManagerRegistry $mr): Category
    {
        $cat = (new CategoryRepository($mr))->findOneBy(['name' => $name]);
        if (!$cat) {
            $cat = new Category();
            $cat->setName($name);
        }

        return $cat;
    }

    /**
     * @param string $weight
     * @return array
     */
    private function parseWeight(string $weight): array
    {
        return explode(' ', $weight);
    }
}
