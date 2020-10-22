<?php


namespace App\World;


class WorldNode
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var bool
     */
    private $bomb;

    /**
     * @var int
     */
    private $bombsAround;

    /**
     * @return int
     */
    public function getX(): int {
        return $this->x;
    }

    /**
     * @param int $x
     *
     * @return WorldNode
     */
    public function setX(int $x): WorldNode {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int {
        return $this->y;
    }

    /**
     * @param int $y
     *
     * @return WorldNode
     */
    public function setY(int $y): WorldNode {
        $this->y = $y;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBomb(): bool {
        return $this->bomb;
    }

    /**
     * @param bool $bomb
     *
     * @return WorldNode
     */
    public function setBomb(bool $bomb): WorldNode {
        $this->bomb = $bomb;
        return $this;
    }

    /**
     * @return int
     */
    public function getBombsAround(): int {
        return $this->bombsAround;
    }

    /**
     * @param int $bombsAround
     *
     * @return WorldNode
     */
    public function setBombsAround(int $bombsAround): WorldNode {
        $this->bombsAround = $bombsAround;
        return $this;
    }


}