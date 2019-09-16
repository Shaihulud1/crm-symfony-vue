<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{

    /**
     * @var integer HTTP status code - 200 (OK) by default
     */
    protected $statusCode = 200;

    /**
     * Gets the value of statusCode.
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param array $headers
     */
    public function respond($data, $headers = [])
    {
        return $this->response($data, $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $errors
     */
    public function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'errors' => $errors,
        ];
        return $this->response($data, $headers);
    }


    public function respondUnauthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithErrors($message);
    }

    private function response($body, $headers)
    {
        $response = new \Symfony\Component\HttpFoundation\Response;
        $response->setContent(json_encode($body));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Request-Method', '*');
        if(!empty($headers))
        {
            foreach($headers as $key => $val)
            {
                $response->headers->set($key, $val);
            }
        }
        return $response;
    }
}
