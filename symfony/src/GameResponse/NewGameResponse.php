<?php


namespace App\GameResponse;


use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class NewGameResponse
{
    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $size;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $bombs;

    /**
     * @var UuidInterface
     * @Assert\NotBlank
     * @Assert\Type(type="UuidInterface")
     */
    private $mapId;

    /**
     * @return int
     */
    public function getSize(): int {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return NewGameResponse
     */
    public function setSize(int $size): NewGameResponse {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int
     */
    public function getBombs(): int {
        return $this->bombs;
    }

    /**
     * @param int $bombs
     *
     * @return NewGameResponse
     */
    public function setBombs(int $bombs): NewGameResponse {
        $this->bombs = $bombs;
        return $this;
    }

    /**
     * @return UuidInterface
     */
    public function getMapId(): UuidInterface {
        return $this->mapId;
    }

    /**
     * @param UuidInterface $mapId
     *
     * @return NewGameResponse
     */
    public function setMapId(UuidInterface $mapId): NewGameResponse {
        $this->mapId = $mapId;
        return $this;
    }


}