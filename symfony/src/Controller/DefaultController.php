<?php

namespace App\Controller;


use App\Response\ErrorResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExceptionController
 *
 * @package App\Controller
 */
class DefaultController extends AbstractFOSRestController
{
    /**
     * @return Response
     */
    public function indexAction() {
        $response = new ErrorResponse();

        $response->setMessage('nope');
        $view = $this->view($response, Response::HTTP_NOT_FOUND);

        return $this->getViewHandler()->handle($view);
    }
}