<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\InWork;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/rest/user")
 */

class UserController extends ApiController
{

    /**
     * @Route("/session/{userID}/{token}",  methods={"GET"})
     */
    public function sessionAction($userID, $token)
    {
         $em = $this->getDoctrine()->getManager();
         $user = $em->getRepository(User::class)->findOneBy(['id' => $userID, 'apitoken' => $token]);
         if(!$user){
            return $this->respond('BAD_AUTH');
         }
         $qb = $em->createQueryBuilder();
         $inWorks = $qb->select('i')
             ->from(InWork::class, 'i')
             ->where(
                 $qb->expr()->gt('i.timeWork', time())
             )
             ->andWhere('i.user = :userObj')
             ->setParameter('userObj', $user)
             ->getQuery()
             ->getResult();
         if($inWorks){
             foreach($inWorks as $inWork)
             {
                $inWork->setTimeWork($inWork->getNewTimeWork());
                $em->merge($inWork);
             }
             $em->flush();
         }
         return $this->respond('DONE');
    }

    /**
     * @Route("/bytoken/{tokenUser}",  methods={"GET"})
     */
    public function getByTokenAction($tokenUser, EntityManagerInterface $em)
    {
        $userData = $em->getRepository(User::class)->findOneBy(['apitoken' => $tokenUser]);
        $result = [
            'fullName' => $userData->getFullName(),
            'id' => $userData->getId(),
        ];
        $inWorks = $userData->getInWorks();
        $curTime = time();
        foreach($inWorks as $work)
        {
            if($work->getTimeWork() < $curTime){
                continue;
            }
            $result['in_work'][$work->getWorkType()][] = [
                'time_work' => $work->getTimeWork(),
                'id_mp' => $work->getObjID(),
                //from oracle
                'prod_name' => $work->getObjID() == 543 ? 'Ношпа' : 'Нурофен',
            ];
        }
        return $this->respond($result);
    }
}
