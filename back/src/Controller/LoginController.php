<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends ApiController
{
    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function login()
    {
        return $this->respond(['auth' => 'Y']);
    }
}
