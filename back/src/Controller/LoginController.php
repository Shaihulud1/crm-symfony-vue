<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

class LoginController extends ApiController
{
    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function login(UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $em)
    {
        $requestData = [
            'username' => $request->request->get("username"),
            'password' => $request->request->get("password")
        ];
        $userFind = $em->getRepository(\App\Entity\User::class)->findOneBy( ['username' => $requestData['username'], 'password' => md5(md5(md5($requestData['password']))) ]);
        $user = new \App\Entity\User();
        if( !$userFind ){
            return $this->respondWithErrors('BAD_AUTH');
        }

        $uniqueToken = false;
        $token = false;
        while(!$uniqueToken)
        {
            $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
            $tokenQuery = $em->getRepository(\App\Entity\User::class)->findOneBy(['apitoken' => $token]);
            if(!$tokenQuery){ $uniqueToken = true; }
        }
        $tokenDeathTime = (6 * 86400) + time();
        $userFind->setApitoken($token);
        $userFind->setTokenDeathDate($tokenDeathTime);
        $em->persist($userFind);
        $em->flush();
        return $this->respond($token);
    }
}
