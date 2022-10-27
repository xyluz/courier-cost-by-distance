<?php namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\class\CourierCost;

/**
 * Initializing a new instalce of the CourierCost Calculator
 */
$calculator = new CourierCost();

/**
 * Usage 1:
 * 
 * Set Drop off Locations 
 * - distance in relation to pick up location
 * - distance in mile
 * Set Cost Per Mile in pounds per mile
 * Set Extra Person Price
 * Call the calculate method with optional boolean parameter - set to true if extra person is needed
 */
$calculator->setDropOff([190,220,40,2]); 

/** Below individual set drop offs does the same as above */

$calculator->setDropOff(190);
// $calculator->setDropOff(220);
// $calculator->setDropOff(40);
// $calculator->setDropOff(23);

$calculator->setCostPerMile(2.5);
$calculator->setExtraPersonPrice(23);
dd($calculator->calculate(true));


/**
 * Usage 2:
 * 
 * Call the calculate method with the following parameters:
 * optional boolean parameter - set to true if extra person is needed
 * optional drop-off locations (array needed)
 * optional cost per mile
 * optional extra person price
 */

// dd($calculator->calculate(true,220,34,65)); // dd($calculator->calculate(true,null,34,65));

//if you try both usage 1 and 2, usage 2 takes preference. 