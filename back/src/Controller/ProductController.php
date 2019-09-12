<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rest")
 */
class ProductController extends ApiController
{
    /**
    * @Route("/product")
    */
    public function productAction()
    {
        return $this->respond([
            [
                'title' => 'product1',
                'count' => 0
            ],
            [
                'title' => 'product2',
                'count' => 0
            ],
            [
                'title' => 'product3',
                'count' => 0
            ]
        ]);
    }
}
