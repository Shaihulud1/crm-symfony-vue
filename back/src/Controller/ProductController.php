<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rest")
 */
class ProductController extends ApiController
{
    /**
    * @Route("/product",  methods={"GET"})
    */
    public function productAction()
    {
        return $this->respond([
            [
                'id_mp' => 242,
                'prod_name' => 'Нурофен',
                'in_work' => 1,
                'date_insert' => "19.08.2019",
            ],
            [
                'id_mp' => 543,
                'prod_name' => 'Ношпа',
                'in_work' => 0,
                'date_insert' => "19.08.2019",
            ],
        ]);
    }

    /**
    * @Route("/product/{id}",  methods={"GET"})
    */
    public function singleproductAction($id)
    {
        if($id == '242')
        {
            return $this->respond([
                'id_mp' => 242,
                'prod_name' => 'Нурофен',
                'in_work' => 1,
                'date_insert' => "19.08.2019",
            ]);
        }else{
            return $this->respond([
                'id_mp' => 543,
                'prod_name' => 'Ношпа',
                'in_work' => 1,
                'date_insert' => "19.08.2019",
            ]);
        }
    }
}
