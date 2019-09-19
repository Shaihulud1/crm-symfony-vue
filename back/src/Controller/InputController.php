<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/rest/inputs")
 */
class InputController extends ApiController
{
    /**
     * @Route("/userdata/{tokenUser}",  methods={"GET"})
     */
    public function userdataAction($tokenUser, EntityManagerInterface $em)
    {
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $tokenUser]);
        return $this->respond([
            'fullName' => $userData->getFullName(),
        ]);
    }

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
