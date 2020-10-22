<?php


namespace App\World;


use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WorldInputParams
 *
 * @Assert\Expression(
 *      "this.getBombs() <= 0.75 * this.getSize() * this.getSize()",
 *     message="Too much bombs!"
 *     )
 *
 * @package App\World
 */
class WorldInputParams
{
    /**
     * @var int
     *
     * @Assert\NotBlank
     * @Assert\Range(
     *     min=5,
     *     max=100,
     *      notInRangeMessage="Size must be in range {{ min }}..{{ max }} but {{ value }} provided"
     * )
     */
    private $size;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Range(
     *     min=5,
     *     max=1000,
     *     notInRangeMessage="Bombs must be in range {{ min }}..{{ max }} but {{ value }} provided"
     * )
     */
    private $bombs;

    /**
     * @return int
     */
    public function getSize(): int {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return WorldInputParams
     */
    public function setSize(int $size): WorldInputParams {
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
     * @return WorldInputParams
     */
    public function setBombs(int $bombs): WorldInputParams {
        $this->bombs = $bombs;
        return $this;
    }


}