<?php


namespace App\World;


class WorldGenerator
{
    /**
     * @param WorldInputParams $inputParams
     *
     * @return WorldNode[][]
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
        /**
         * @var WorldNode[][] $map
         */
        $map = [];
        for ($x = 0; $x < $size; $x++) {
            $row = [];
            for ($y = 0; $y < $size; $y++) {
                $setBomb = array_pop($arrayOfBombs);
                $node = new WorldNode();
                $node
                    ->setX($x)
                    ->setY($y)
                    ->setBomb($setBomb)
                    ->setBombsAround(0);

                $row[] = $node;
            }
            $map[] = $row;
        }

        // calc bombs around of each node
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $node = $map[$x][$y];
                if (!$node->hasBomb()) {
                    $node = $this->calcBombsAround($node, $map);
                }
                $map[$x][$y] = $node;
            }
        }

        return $map;
    }

    /**
     * @param WorldNode $node
     * @param WorldNode[][] $map
     *
     * @return WorldNode
     */
    private function calcBombsAround(WorldNode $node, array $map): WorldNode {
        $nodeX = $node->getX();
        $nodeY = $node->getY();

        $size = count($map);

        $bombsAround = $node->getBombsAround();

        for ($x = $nodeX - 1; $x <= $nodeX + 1; $x++) {
            if ($x < 0 || $x >= $size) {
                continue;
            }
            for ($y = $nodeY - 1; $y <= $nodeY + 1; $y++) {
                if ($y < 0 || $y >= $size) {
                    continue;
                }
                $adjNode = $map[$x][$y];
                $bombsAround += $adjNode->hasBomb() ? 1 : 0;
            }
        }

        $node->setBombsAround($bombsAround);

        return $node;
    }
}