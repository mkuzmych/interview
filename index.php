<?php

/**
 * Factory for robot
 */
class FactoryRobot
{
    public $type;

    public function addType($type) {
        $this->type = $type;
    }

    public function createRobot1($count) {
        $result = array();
        for ($i = 0; $i < $count; $i++) {
            $result[$i] = new Robot1();
        }
        return $result;
    }

    public function createRobot2($count) {
        $result = array();
        for ($i = 0; $i < $count; $i++) {
            $result[$i] = new Robot2();
        }
        return $result;
    }

    public function createMergeRobot(int $count) {
        $result = array();
        for ($i = 0; $i < $count; $i++) {
            $result[$i] = $this->type;
        }
        return $result;
    }
}

/**
 * Simple robot
 */
class Robot1
{
    public $weight = 160;
    public $speed = 180;
    public $height = 200;
}
/**
 * Simple robot
 */
class Robot2
{
    public $weight = 100;
    public $speed = 120;
    public $height = 140;
}

/**
 * Merged robots
 */
class MergeRobot
{
    public $robots;

    public function addRobot($addedRobots) {
        $robots = !is_array($addedRobots) ? array($addedRobots) : $addedRobots;
        foreach ($robots as $robot) {
            $this->robots[] = $robot;
        }
    }

    public function getSpeed() {
        return max(array_map(function($item) {
                return $item->speed;
            },
            (array) $this->robots));
    }
    public function getWeight() {
        return array_sum(array_map(function($item) {
                return $item->weight;
            },
            (array) $this->robots));
    }
    public function getHeight() {
        return array_sum(array_map(function($item) {
                return $item->height;
            },
            (array) $this->robots));
    }
}

$factory = new FactoryRobot();

$factory->addType(new Robot1());
$factory->addType(new Robot2());

echo '<pre>';
var_dump($factory->createRobot1(5));
echo '</pre>';
echo '<pre>';
var_dump($factory->createRobot2(2));
echo '</pre>';


$mergeRobot = new MergeRobot();
$mergeRobot->addRobot(new Robot2());
$mergeRobot->addRobot($factory->createRobot2(2));
$factory->addType($mergeRobot);
$res = $factory->createMergeRobot(1);
$result = reset($res);

echo '<pre>';
var_dump($result->getSpeed());
echo '</pre>';
echo '<pre>';
var_dump($result->getWeight());
echo '</pre>';
echo '<pre>';
var_dump($result->getHeight());
echo '</pre>';
die;