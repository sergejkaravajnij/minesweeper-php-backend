<?php

namespace App\Entity;

use App\Repository\WorldMapRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=WorldMapRepository::class)
 */
class WorldMap
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     */
    private $id;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $map = [];

    /**
     * WorldMap constructor.
     */
    public function __construct() {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getMap(): ?array {
        return $this->map;
    }

    /**
     * @param array $map
     *
     * @return $this
     */
    public function setMap(array $map): self {
        $this->map = $map;

        return $this;
    }
}
