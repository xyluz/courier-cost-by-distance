<?php 

namespace App\class;


use App\interface\Calculator as CalculatorInterface;
use App\class\Database;

// generate costs for a courier service.
// calculator will calculate costs for a driver and their van undertaking a delivery job.

// Your module should factor in:
// The distance between the pickup location and the drop-off location(s)
// Anything between 1 and 5 drop-off locations
// A cost per mile that won't be the same for every job
// An optional cost for a second person to help the driver with the delivery job
// The need for a consistent quote data structure that can be shared with other calculators and passed to other modules

// The resulting pricing data should include the following items:
// Number of drop-offs
// Total distance
// Cost per mile
// Extra person price
// Total price
// Any other data you might think is relevant

/**
 * Calcuator =>  [
 *      "pick-up-location"=>10m,
 *      "drop-offs"=>[
 *          a => 55 
 *          b => 13 
 *          c => 22 
 *      ],
 *      "cost-per-mile"=>1,
 *      "extra-person-price"=>15
 * ]
 */

class CourierCost extends Database implements CalculatorInterface
{

    protected $cost_per_mile = 0;
    protected $drop_offs = [];


    public function __construct()
    {
        //db connection
    }

    public function calculate():Array{

        return [];
    }

    public function setDropOff($distance):void{
        $this->drop_offs[] = $distance;
    }

    public function getDropOffs():Array{
        return $this->drop_offs;
    }

    public function setCostPerMile($cost = 1):void{
        $this->cost_per_mile = $cost;
    }

    public function getCostPerMile():float{
        return $this->cost_per_mile ?? 0;
    }

}
