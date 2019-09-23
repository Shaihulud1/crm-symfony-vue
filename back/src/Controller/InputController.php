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

                ]
            ],
        ]);
    }

    /**
     * @Route("/prop/{subsecID}",  methods={"GET"})
     */
    public function propAction($subsecID)
    {
        if($subsecID == 12){
            return $this->respond([
                [
                    'id' => 1,
                    'name' => 'Prop 1',
                    'group' => 'Group 3',
                    'subsection' => 'subsect 12',
                    'isActive' => 'Да',
                ],
            ]);
        }
        elseif($subsecID == 51)
        {
            return $this->respond([
                [
                    'id' => 2,
                    'name' => 'Prop 2',
                    'group' => 'Group 3',
                    'subsection' => 'subsect 51',
                    'isActive' => 'Да',
                ],
            ]);
        }

    }

    /**
     * @Route("/mnn",  methods={"GET"})
     */
    public function mnnAction()
    {
        return $this->respond([
            [
                'id' => 1,
                'name' => 'Mnn1',
                'isActive' => 'Да',
            ],
            [
                'id' => 2,
                'name' => 'Mnn2',
                'isActive' => 'Да',
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
