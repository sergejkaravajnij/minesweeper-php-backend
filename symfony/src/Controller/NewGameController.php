<?php


namespace App\Controller;


use App\Response\SuccessResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewGameController
 *
 * @Rest\Route(path="/new-game")
 *
 * @package App\Controller
 */
class NewGameController extends AbstractFOSRestController
{
    /**
     * @Rest\Route(methods={"GET"})
     * @return Response
     */
    public function createAction() {
        $response = new SuccessResponse();

        $response->setData(['OK']);
        $view = $this->view($response);

        return $this->getViewHandler()->handle($view);
    }
}