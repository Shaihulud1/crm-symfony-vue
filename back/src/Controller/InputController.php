<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\OracleDB;
use App\Entity\User;


/**
 * @Route("/rest/inputs")
 */
class InputController extends ApiController
{
    /**
     * @Route("/brand",  methods={"GET"})
     */
    public function brandAction(EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}
        
        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $brands = $oracleDB->getBrands();
        $gammas = $oracleDB->getGammas();
        foreach($gammas as $gamma)
        {
            if(!empty($brands[$gamma['idBrand']]))
            {
                $brands[$gamma['idBrand']]['childs'][] = $gamma;
            }

        }
        $brands = array_values($brands);
        return $this->respond($brands);
    }

    /**
     * @Route("/section",  methods={"GET"})
     */
    public function sectionAction(EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $sections = $oracleDB->getSections();
        $subSections = $oracleDB->getSubSections();
        foreach($subSections as $subSect)
        {
            if(!empty($sections[$subSect['idSect']]))
            {
                $sections[$subSect['idSect']]['childs'][] = $subSect;
            }

        }
        $sections = array_values($sections);
        return $this->respond($sections);
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
