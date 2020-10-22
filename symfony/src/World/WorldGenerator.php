<?php


namespace App\World;


class WorldGenerator
{
    /**
     * @param WorldInputParams $inputParams
     *
     * @return array
     */
    public function generate(WorldInputParams $inputParams) {
        // spread bombs randomly into array
        $size = $inputParams->getSize();
        $numCells = pow($size, 2);
        $bombs = $inputParams->getBombs();
        $arrayOfBombs = array_fill_keys(range(1, $bombs), true);
        $arrayOfBombs = array_pad($arrayOfBombs, $numCells, false);
        shuffle($arrayOfBombs);

        // put them to the world
        $map = [];
        for ($x = 0; $x < $size; $x++) {
            $row = [];
            for ($y = 0; $y < $size; $y++) {
                $setBomb = array_pop($arrayOfBombs);
                $row[] = $setBomb ? 'b' : 0;
            }
            $map[] = $row;
        }

        // calc bombs around of each node
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                if ($map[$x][$y] !== 'b') {
                    $map[$x][$y] = $this->calcBombsAround($x, $y, $map);
                }
            }
        }

        return $map;
    }

    /**
     * @param int $nodeX
     * @param int $nodeY
     * @param array $map
     *
     * @return int
     */
    private function calcBombsAround(int $nodeX, int $nodeY, array $map): int {
        $size = count($map);

        $bombsAround = 0;

        for ($x = $nodeX - 1; $x <= $nodeX + 1; $x++) {
            if ($x < 0 || $x >= $size) {
                continue;
            }
            for ($y = $nodeY - 1; $y <= $nodeY + 1; $y++) {
                if ($y < 0 || $y >= $size) {
                    continue;
                }
                $adjNode = $map[$x][$y];
                $bombsAround += $adjNode === 'b' ? 1 : 0;
            }
        }

        return $bombsAround;
    }
}