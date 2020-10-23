<?php


namespace App\Controller;


use App\Entity\WorldMap;
use App\Exception\PublicException;
use App\Response\SuccessResponse;
use App\World\TurnInputParams;
use App\World\WorldGenerator;
use App\World\WorldInputParams;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class GameController
 *
 * @package App\Controller
 */
class GameController extends AbstractFOSRestController
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GameController constructor.
     *
     * @param WorldGenerator $worldGenerator
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        WorldGenerator $worldGenerator,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->worldGenerator = $worldGenerator;
        $this->entityManager = $entityManager;
    }


    /**
     * @Rest\Route(path="/game/new/size/{size<\d+>}/bombs/{bombs<\d+>}", methods={"GET"})
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

        $worldEntity = new WorldMap();
        $worldEntity->setMap($world);

        $this->entityManager->persist($worldEntity);
        $this->entityManager->flush();

        $data = [
            'size' => $size,
            'bombs' => $bombs,
            'map_id' => $worldEntity->getId()
        ];

        $response = new SuccessResponse();

        $response->setData($data);
        $view = $this->view($response);

        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Rest\Route(path="/game/turn", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws PublicException
     */
    public function turnAction(Request $request) {
        $data = json_decode($request->getContent(), true);
        $mapId = $data['map_id'] ?? '';
        $coords = $data['coords'] ?? '';

        $inputParams = new TurnInputParams();
        $inputParams
            ->setMapId($mapId)
            ->setCoords($coords);

        $errors = $this->validator->validate($inputParams);

        if (count($errors) > 0) {
            throw new PublicException($errors->get(0)->getMessage());
        }

        $world = $this->entityManager->find(WorldMap::class, $mapId);

        if (!$world) {
            throw new PublicException("'Map doesn't exist'");
        }

        $map = $world->getMap();

        $size = count($map);

        $x = $coords[0];
        $y = $coords[1];
        if ($x >= $size || $y >= $size) {
            throw new PublicException('Out of the map');
        }

        $response = new SuccessResponse();

        if ($map[$x][$y] === 'b') {
            // boom
            $data = [
                'die' => 1,
                'open' => []
            ];

        } else {
            //expose number or empty area
            $data = [
                'die' => 0,
                'open' => []
            ];
        }

        $response->setData($data);

        $view = $this->view($response);

        return $this->getViewHandler()->handle($view);
    }
}