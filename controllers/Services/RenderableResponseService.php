<?php

namespace Controllers\Services;

use PHPNomad\Rest\Interfaces\Response;
use PHPNomad\Template\Interfaces\CanRender;

class RenderableResponseService
{
    public function __construct(protected CanRender $render)
    {

    }

    public function getResponse(Response $response, $path, $title, $args = []) : Response
    {
        $args['title'] = $title;
        return $response->setBody($this->render->render($path, $args));
    }
}