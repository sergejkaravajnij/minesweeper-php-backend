<?php


namespace App\World;


class WorldService
{
    /**
     * @var array
     */
    private $map;

    /**
     * @param array $map
     *
     * @return array
     */
    public function getBombsMap(array $map) {
        foreach ($map as &$row) {
            $row = array_filter($row, function ($cell) {
                return $cell === 'b';
            });
        }

        $map = array_filter($map);

        return $this->flatten($map);
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return array
     */
    public function getAreaToExpose(int $x, int $y) {
        $expose = [];
        $curCell = &$this->map[$x][$y];

        $expose[] = [$x, $y, $curCell];

        if ($curCell > 0) {
            $curCell = 'v';
            return $expose;
        }

        $curCell = 'v';

        for ($i = $x - 1; $i <= $x + 1; $i++) {
            for ($j = $y - 1; $j <= $y + 1; $j++) {
                if (!isset($this->map[$i][$j])) {
                    continue;
                }
                $curCell = &$this->map[$i][$j];

                if ($curCell !== 'b' && $curCell !== 'v') {
                    $expose = array_merge($expose, $this->getAreaToExpose($i, $j));
                    $curCell = 'v';
                }
            }
        }

        return $expose;
    }


    /**
     * @param array|null $map
     *
     * @return array
     */
    private function flatten(?array $map) {
        $flatArray = [];
        foreach ($map as $x => $row) {
            foreach ($row as $y => $cell) {
                $flatArray[] = [$x, $y, $cell];
            }
        }

        return $flatArray;
    }

    /**
     * @param array $map
     *
     * @return WorldService
     */
    public function setMap(array $map): self {
        $this->map = $map;

        return $this;
    }
}