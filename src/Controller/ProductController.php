<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\FileService;
use App\Services\RequestHelper;
use App\Services\XmlService;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $queryParams = (new RequestHelper($request->query->all()))->stripQueryParams();

        /** @var ProductRepository $res */
        $res = $doctrine
            ->getRepository(Product::class);

        dd($res
            ->findFilteredQueryBuilder($queryParams)
            ->getQuery()
            );
        $products = $res
            ->findFilteredQueryBuilder($queryParams)
            ->getQuery()
            ->getResult();

        $form = $this->createFormBuilder()
            ->setMethod('get')
            ->add('name', TextType::class, ['required'=>false])
            ->add('weigth', TextType::class, ['required'=>false])
            ->add('sortName', SubmitType::class, [
                'label' => 'Сортировака по имени',
                'attr' =>[
                    'value' => 'true',
                ]
            ])
            ->add('sortWeight', SubmitType::class, [
                'label' => 'Сортировка по весу',
                'attr' =>[
                    'value' => 'true',
                ]
            ])
            ->add('filter', SubmitType::class, ['label' => 'Фильтр'])
            ->getForm()
            ->createView();

        $counPages = intdiv($res->getCount(), ProductRepository::RECORDS_PER_PAGE);
        $pagesForm = $this->createFormBuilder()
            ->setMethod('get');
        for($page = 1; $page <= $counPages; $page++) {
            $pagesForm->add($page, SubmitType::class);
        }

        return $this->render(
            'product/index.html.twig',
            [
                'products' => $products,
                'form' => $form,
                'pagesForm' => $pagesForm->getForm()->createView(),
                'countPages' => $counPages,
                'activePage' => $queryParams['page'],
            ]
        );
    }

    /**
     * @throws Exception
     */
    #[Route('/file_upload', name: 'file_upload')]
    public function uploadFile(Request $request, ManagerRegistry $doctrine, LoggerInterface $logger) //здесь можно стримингом воспользоваться. Не хватает времени написать
    {
        try {
            $res = (new FileService())->readFile($request, $doctrine);
        } catch (FileException $e) {
            $logger->alert('fileErrorUpload', ['exeption' => $e]);
            return $this->redirectToRoute('app_product');
        }

        $logger->info('upload file success', ['records' => $res]);

        return $this->redirectToRoute('app_product');
    }
}
