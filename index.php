<?php namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\class\CourierCost;

/**
 * Initializing
 */
$calculator = new CourierCost();

/**
 * Set Drop off Locations 
 * - distance in relation to pick up location
 * - distance in mile
 */
$calculator->setDropOff(10);
$calculator->setDropOff(12);
$calculator->setDropOff(14);

$all_drop_offs = $calculator->getDropOffs();

$calculator->setCostPerMile(2.5);

$calculator->setExtraPersonPrice();

dd($calculator->calculate());


