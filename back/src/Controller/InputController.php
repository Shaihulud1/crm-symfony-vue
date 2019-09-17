<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rest/inputs")
 */
class InputController extends ApiController
{
    /**
     * @Route("/brands",  methods={"GET"})
     */
    public function brandAction()
    {
        return $this->respond([
            [
                'id_mp' => 1,
                'brand_name' => 'Brand 1',
                'gammas' => [
                    [
                        'id' => 54,
                        'gamma_name' => 'Gamma 1',
                    ],
                    [
                        'id' => 55,
                        'gamma_name' => 'Gamma 2',
                    ],
                ]
            ],
            [
                'id_mp' => 2,
                'brand_name' => 'Brand 2',
            ],
        ]);
    }

    /**
     * @Route("/section",  methods={"GET"})
     */
    public function sectionAction()
    {
        return $this->respond([
            [
                'id' => 1,
                'name' => 'Лекарства и БАДы',
                'subsections' => [
                    [
                        'id' => 12,
                        'name' => 'БАДы'
                    ],
                    [
                        'id' => 11,
                        'name' => 'Лекарства'
                    ],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Медицинские приборы',
                'subsections' => [
                    [
                        'id' => 51,
                        'name' => 'Медицина'
                    ],
                    [
                        'id' => 71,
                        'name' => 'Приборы'
                    ],
                ]
            ],
        ]);
    }

    /**
     * @Route("/props",  methods={"GET"})
     */
    public function propAction()
    {
        return $this->respond([
            [
                'id_mp' => 1,
                'prop' => 'Prop 1',
            ],
            [
                'id_mp' => 2,
                'prop' => 'Prop 2',
            ],
        ]);
    }


    /**
     * @Route("/prodform",  methods={"GET"})
     */
    public function prodformAction()
    {
        return $this->respond([
            [
                'id_mp' => 11312,
                'prop' => 'ProdForm 1',
            ],
            [
                'id_mp' => 1213,
                'prop' => 'ProdForm 523',
            ],
        ]);
    }
}
