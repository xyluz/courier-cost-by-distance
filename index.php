<?php namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\class\CourierCost;


$calculator = new CourierCost();


$calculator->setDropOff(10);
$calculator->setDropOff(12);
$calculator->setDropOff(14);

$all_drop_offs = $calculator->getDropOffs();

$calculator->setCostPerMile = 2;

dd($calculator->getCostPerMile());

