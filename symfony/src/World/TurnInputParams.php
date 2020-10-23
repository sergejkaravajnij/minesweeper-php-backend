<?php


namespace App\World;


use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class TurnInputParams
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $mapId;

    /**
     * @var array
     * @Assert\NotBlank
     * @Assert\Type(type="array")
     * @Assert\Count(min=2, max=2)
     */
    private $coords;

    /**
     * @return string
     */
    public function getMapId(): string {
        return $this->mapId;
    }

    /**
     * @param string $mapId
     *
     * @return TurnInputParams
     */
    public function setMapId(string $mapId): TurnInputParams {
        $this->mapId = $mapId;
        return $this;
    }

    /**
     * @return array
     */
    public function getCoords(): array {
        return $this->coords;
    }

    /**
     * @param array $coords
     *
     * @return TurnInputParams
     */
    public function setCoords(array $coords): TurnInputParams {
        $this->coords = $coords;
        return $this;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function validate(ExecutionContextInterface $context, $payload) {

        try {
            Uuid::fromString($this->getMapId());
        } catch (InvalidUuidStringException $e) {
            $context->buildViolation('map_id must be an uuid')
                ->addViolation();
        }
    }

}