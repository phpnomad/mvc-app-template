<?php

namespace Controllers;

use Controllers\Services\RenderableResponseService;
use PHPNomad\Rest\Interfaces\Response;
use PHPNomad\Rest\Interfaces\WebController;

class HomeController implements WebController
{
    public function __construct(protected RenderableResponseService $service)
    {

    }

    /**
     * @inheritDoc
     */
    public function response(Response $response) : Response
    {
        return $this->service->getResponse($response,'index', 'Home');
    }
}