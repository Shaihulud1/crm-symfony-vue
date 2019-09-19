<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\InWork;
use Doctrine\ORM\EntityManagerInterface;


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
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $inWorks = $qb->select('i')
            ->from(InWork::class, 'i')
            ->where(
                $qb->expr()->gt('i.timeWork', time())
            )
            // ->andWhere(
            //     $qb->expr()->in('i.objID', ':ids')
            // )
            // ->setParameter('ids', [242, 543])
            ->getQuery()
            ->getResult();
        $inWorkIDs = [];
        foreach($inWorks as $inWork)
        { 
            $inWorkIDs[] = $inWork->getObjID();
        }
        return $this->respond([
            [
                'id_mp' => 242,
                'prod_name' => 'Нурофен',
                'in_work' => in_array(242, $inWorkIDs) ? 1 : 0,
                'date_insert' => "19.08.2019",
            ],
            [
                'id_mp' => 543,
                'prod_name' => 'Ношпа',
                'in_work' => in_array(543, $inWorkIDs) ? 1 : 0,
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

    /**
    * @Route("/product/openproduct/{id}/{userID}/{token}",  methods={"GET"})
    */
    public function openProductAction($id, $userID, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $existProd = [242, 543];
        if(!in_array($id, $existProd)){
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

    /**
    * @Route("/product/mass",  methods={"POST"})
    */
    /*
    public function massProductAction($prods)
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
    */
}
