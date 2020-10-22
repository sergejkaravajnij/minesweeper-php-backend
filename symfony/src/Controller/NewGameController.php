<?php


namespace App\Controller;


use App\Exception\PublicException;
use App\Response\SuccessResponse;
use App\World\WorldGenerator;
use App\World\WorldInputParams;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class NewGameController
 *
 * @package App\Controller
 */
class NewGameController extends AbstractFOSRestController
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var WorldGenerator
     */
    private $worldGenerator;

    /**
     * NewGameController constructor.
     *
     * @param WorldGenerator $worldGenerator
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(WorldGenerator $worldGenerator, ValidatorInterface $validator, SerializerInterface $serializer) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->worldGenerator = $worldGenerator;
    }


    /**
     * @Rest\Route(path="/new-game/size/{size<\d+>}/bombs/{bombs<\d+>}", methods={"GET"})
     *
     * @param int $size
     * @param int $bombs
     *
     * @return Response
     * @throws PublicException
     */
    public function createAction(int $size, int $bombs) {

        $worldParams = new WorldInputParams();
        $worldParams
            ->setSize($size)
            ->setBombs($bombs);

        $errors = $this->validator->validate($worldParams);

        if (count($errors) > 0) {
            throw new PublicException($errors->get(0)->getMessage());
        }

        $world = $this->worldGenerator->generate($worldParams);

        // save world to database and return the game id as response

        $response = new SuccessResponse();

        $response->setData(['OK']);
        $view = $this->view($response);

        return $this->getViewHandler()->handle($view);
    }
}