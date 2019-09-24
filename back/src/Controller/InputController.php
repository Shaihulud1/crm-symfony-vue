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
                $gamma['name'] .= ' | '. $brands[$gamma['idBrand']]['name'];
                $brands[$gamma['idBrand']]['childs'][] = $gamma;
            }

        }
        $brands = array_values($brands);
        return $this->respond($brands);
    }


    /**
     * @Route("/desc",  methods={"GET"})
     */
    public function descUploadAction(EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $descrs = $oracleDB->getDescripts();
        return $this->respond($descrs);

    }


    /**
     * @Route("/desc/{id}",  methods={"GET"})
     */
    public function descSingleAction($id, EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $descr = $oracleDB->getDescriptByID($id);
        return $this->respond(!empty($descr) ? $descr : "EMPTY_DATA");

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
    public function propAction($subsecID, EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $subsectGroups = $oracleDB->getPropsWithGroups((int)$subsecID);
        return $this->respond(!empty($subsectGroups) ? $subsectGroups : "EMPTY_DATA");


    }

    /**
     * @Route("/mnn",  methods={"GET"})
     */
    public function mnnAction(EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $mnns = $oracleDB->getMnns();
        return $this->respond($mnns);
    }


    /**
     * @Route("/prodform",  methods={"GET"})
     */
    public function prodformAction(EntityManagerInterface $em, Request $request)
    {
        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $forms = $oracleDB->getForms();
        return $this->respond($forms);
    }
}
