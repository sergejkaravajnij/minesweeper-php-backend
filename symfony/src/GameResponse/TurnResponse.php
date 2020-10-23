<?php


namespace App\GameResponse;


use Symfony\Component\Validator\Constraints as Assert;

class TurnResponse
{
    /**
     * @var bool
     * @Assert\Type(type="bool")
     */
    private $die;

    /**
     * @var
     * @Assert\Type(type="array")
     */
    private $open;

    /**
     * @return bool
     */
    public function isDie(): bool {
        return $this->die;
    }

    /**
     * @param bool $die
     *
     * @return TurnResponse
     */
    public function setDie(bool $die): TurnResponse {
        $this->die = $die;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpen() {
        return $this->open;
    }

    /**
     * @param mixed $open
     *
     * @return TurnResponse
     */
    public function setOpen($open) {
        $this->open = $open;
        return $this;
    }
}