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
     * @Route("/brand",  methods={"GET"})
     */
    public function brandAction()
    {
        return $this->respond([
            [
                'id' => 1,
                'name' => 'Brand 1',
                'childs' => [
                    [
                        'id' => 54,
                        'name' => 'Gamma 1',
                    ],
                    [
                        'id' => 55,
                        'name' => 'Gamma 2',
                    ],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Brand 2',
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
                'childs' => [
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
                'childs' => [
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
     * @Route("/prop",  methods={"GET"})
     */
    public function propAction()
    {
        return $this->respond([
            [
                'id' => 1,
                'name' => 'Prop 1',
            ],
            [
                'id' => 2,
                'name' => 'Prop 2',
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
                'id' => 11312,
                'name' => 'ProdForm 1',
            ],
            [
                'id' => 1213,
                'name' => 'ProdForm 523',
            ],
        ]);
    }
}
