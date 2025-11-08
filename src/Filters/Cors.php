<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    protected $allowOrigins = [
        "http://localhost:5173",
        "https://sandbox.axproo.com"
    ];

    /**
     * Summary of before
     * @param \CodeIgniter\HTTP\RequestInterface $request
     * @param mixed $arguments
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        $origin = $request->getServer('HTTP_ORIGIN');

        if ($origin && in_array($origin, $this->allowOrigins)) {
            $this->addCorsHeaders($response, $origin);
        }

        if ($request->getMethod() === 'OPTIONS') {
            if ($origin && in_array($origin, $this->allowOrigins)) {
                $this->addCorsHeaders($response, $origin);
            }
            $response->setHeader('Access-Control-Max-Age', '86400');
            $response->setStatusCode(200);
            $response->setBody('OK');
            return $response->send();
        }
    }

    /**
     * Summary of after
     * @param \CodeIgniter\HTTP\RequestInterface $request
     * @param \CodeIgniter\HTTP\ResponseInterface $response
     * @param mixed $arguments
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $origin = $request->getServer('HTTP_ORIGIN');
        if ($origin && in_array($origin, $this->allowOrigins)) {
            $this->addCorsHeaders($response, $origin);
        }
    }

    /**
     * Summary of addCorsHeaders
     * @param \CodeIgniter\HTTP\ResponseInterface $response
     * @param string $origin
     * @return void
     */
    private function addCorsHeaders(ResponseInterface $response, string $origin) {
        $response->setHeader('Access-Control-Allow-Origin', $origin); // Remplacer * par votre nom de domaine
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization, X-Auth-Token');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
    }
}