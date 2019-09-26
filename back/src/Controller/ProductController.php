<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\InWork;
use Symfony\Component\HttpFoundation\Request;
use App\Service\OracleDB;

/**
 * @Route("/rest")
 */
class ProductController extends ApiController
{
    /**
    * @Route("/new-product",  methods={"GET"})
    */
    public function newProductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $qb = $em->createQueryBuilder();

        $inWorks = $qb->select('i')
            ->from(InWork::class, 'i')
            ->where(
                $qb->expr()->gt('i.timeWork', time())
            )
            ->getQuery()
            ->getResult();
        $inWorkIDs = [];
        foreach($inWorks as $inWork)
        {
            $inWorkIDs[] = $inWork->getObjID();
        }

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $newProds = $oracleDB->getNewProdsList($inWorkIDs);

        return $this->respond($newProds);
    }

    /**
    * @Route("/new-product/openproduct/{id}/{userID}/{token}",  methods={"GET"})
    */
    public function openNewProductByID($id, $userID, $token, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $token = $request->isMethod("GET") ? $request->query->get('auth') : $request->request->get("auth");
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);
        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $newProd = $oracleDB->getNewProdByID($id);
        if(empty($newProd)){
            return $this->respond('BAD_PROD');
        }

        $user = $em->getRepository(User::class)->findOneBy(['id' => $userID, 'apitoken' => $token]);
        if(!$user){
            return $this->respond('BAD_AUTH');
        }

        $qb = $em->createQueryBuilder();

        $inWork = $qb->select('i')
            ->from(InWork::class, 'i')
            ->where(
                $qb->expr()->gt('i.timeWork', time())
            )
            ->andWhere('i.objID = :prodID')
            ->setParameter('prodID', $id)
            ->getQuery()
            ->getOneOrNullResult();
        $returnProd = false;

        if($inWork){
            $userWork = $inWork->getUser();
            if($userID != $userWork->getID())
            {
                return $this->respond('IN_WORK');
            }else{
                $returnProd = true;
            }
        }else{
            $inWorkEntity = new InWork;
            $inWorkEntity->setUser($user);
            $inWorkEntity->setObjID($id);
            $inWorkEntity->setTimeWork($inWorkEntity->getNewTimeWork());
            $inWorkEntity->setWorkType('NP');
            $em->persist($inWorkEntity);
            $em->flush();
            $returnProd = true;
        }
        if($returnProd){
            return $this->respond($newProd);
        }

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



    /**
    * @Route("/product/save-product",  methods={"POST"})
    */
    public function saveProduct(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token = $request->query->get('auth');
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $token]);

        if(!$userData){return $this->respond('BAD_AUTH');}

        $oracleDB = new OracleDB($userData->getId(), $userData->getFullname());
        $arProps = json_decode($request->request->get('propItems'));
        if(!empty($arProps)){
            foreach($arProps as $prop)
            {
                $arParamsProps[] = [
                    'p_id_mp' => $request->request->get('id_mp'),
                    'p_id_br' => false,
                    'p_id_subsec' => $request->request->get('subsection'),
                    'p_id_prop' => $prop->id,
                    'p_id_gamma' => false,
                ];
            }
        }
        $arParamsProps[] = [
            'p_id_mp' => $request->request->get('id_mp'),
            'p_id_br' => $request->request->get('brand'),
            'p_id_subsec' => $request->request->get('subsection'),
            'p_id_prop' => false,
            'p_id_gamma' => $request->request->get('gamma'),
        ];
        $arMnns = json_decode($request->request->get('mnnItems'));
        foreach($arMnns as &$val)
        {
            $val->id_mp = $request->request->get('id_mp');
        }
        $arParams = [
            'p_id_mp' => $request->request->get('id_mp'),
            'p_ph_pr_name' => $request->request->get('prod_name'),
            'p_upac' => $request->request->get('box'),
            'p_firm' => $request->request->get('manufactory'),
            'p_form' => $request->request->get('formProd2'),
            'p_dose' => $request->request->get('dosage'),
            'p_dose_m' => $request->request->get('unit'),
            'p_amount' => $request->request->get('volume'),
            'p_sc_text' => $request->request->get('storageCond'),
            'p_lat_name' => $request->request->get('latinName'),
            'p_recipe' => $request->request->get('isRecipeNeeded') ? 1 : 0,
            'p_is_correct' => 1,
            'p_rus_name' => $request->request->get('rusName'),
            'p_is_br_nm' => 0,
            'p_cat_prior' => $request->request->get('catPrior') ? 1 : 0,
            'p_id_form' => $request->request->get('formProd'),
            'p_id_ppd' => $request->request->get('selectedDesc'),
        ];
        $arProdForm = [];
        if($arParams['p_id_form'] && $request->request->get('formProdShort'))
        {
            $arProdForm = [
                'p_id_form' => $request->request->get('formProd'),
                'p_form_shnm' => $request->request->get('formProdShort'),
            ];
        }
        $oracleDB->saveNewProd($arParams, $arParamsProps, $arMnns, $arProdForm);
        return $this->respond('SAVED');
    }

    /**
    * @Route("/product/closeproduct/{id}/{userID}/{token}",  methods={"GET"})
    */
    public function closeProductAction($id, $userID, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(['id' => $userID, 'apitoken' => $token]);
        if(!$user){
            return $this->respond('BAD_AUTH');
        }
        $arInWork = $user->getInWorks();
        foreach($arInWork as $inWork)
        {
            if($inWork->getObjID() == $id)
            {
                $em->remove($inWork);
            }
        }
        $em->flush();
        return $this->respond('DONE');
    }
}
