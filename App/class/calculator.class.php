<?php 

namespace App\class;


use App\interface\Calculator as CalculatorInterface;
use App\class\Database;
use App\class\Exception;

/**
 * Main Calculator Class *CourierCost*
 *
 * This is the main class required
 * @author Seyi Onifade <xyluz>
 */ 

class CourierCost extends Database implements CalculatorInterface
{

    private $cost_per_mile = 0;
    private $drop_offs = [];
    private $extra_person_price = 0;
    private $time_cost_per_mile_set = null;
    private $pick_up_location = 0; //distance to pick up location, if necessary

    public function __construct()
    {
        parent::__construct();
        //db connection - if needed
        //authentication check if needed

    }

    /**
     * Main calculate function
     *
     * @param Bool   $extra_person  set true if extra person is needed for delivery
     * @param integer $repeat How many times something interesting should happen
     * 
     * @throws Error If invalid drop-off locations set
     * @author Seyi Onifade <xyluz>
     * @return Array
     */ 

    public function calculate(
        Bool $extra_person = false, 
        Bool $account_for_pick_up = false,
        array $drop_offs = null, 
        float $cost_per_mile = null, 
        float $cost_per_extra_person = null
        ):array {

            if(isset($drop_offs)) {
                //empty previous drop-offs if any, and reset
                $this->drop_offs = [];
                $this->setDropOff($drop_offs); 
            } 

            if(isset($cost_per_mile)) $this->setCostPerMile($cost_per_mile);
            if(isset($cost_per_extra_person)) $this->setExtraPersonPrice($cost_per_extra_person);

            $drop_offs_count = count($this->getDropOffs());

            /** 
             *  exclusively checking if drop-offs is between 1 and 5 --> alternatively, this checks if at least 1 drop-off is specified:
             * 
             *  if($drop_offs_count   < 1) return ["Error"=>"Invalid Drop off, at least 1 drop off value must be set"];
             * */ 
            

            if(1 > $drop_offs_count || $drop_offs_count > 5) return ["Error"=>"Invalid Drop off, value must be between 1 and 5"];

            $total_cost = $this->getCostPerMile() * 
                                $this->totalDistance() + ($account_for_pick_up ? $this->getPickUpLocation() : 0) 
                                + ($extra_person ? $this->getExtraPersonPrice() : 0);
                            

            return [
                'cost_data'=>[
                    "price"=>$this->getCostPerMile(),
                    "set_at"=>$this->time_cost_per_mile_set
                ],
                'total_drop_offs'=>$drop_offs_count,
                'total_distance'=> $this->totalDistance(),
                'cost_per_extra_person'=>$this->getExtraPersonPrice(),
                'total_cost'=> $total_cost,
                'distances'=>$this->getDropOffs()
            ];
    }

    /**
     * Set Drop-Off Location
     *
     * @param Array|float   $distance  set drop-off locations using array of float or single float
     * 
     * @throws Exception If invalid drop-off data type
     * @return Void
     */ 

    public function setDropOff(float|array $distance = 1):void{
        
        if(is_string($distance)) throw new \Exception("invalid distance set, distance can be array or single numberic [ float | int ] value - " . gettype($distance)."  given");

        if(is_array($distance)){ 

            $this->drop_offs =  array_merge($distance,$this->drop_offs);
 
        }
        elseif (is_numeric($distance)) { 

            array_push($this->drop_offs,$distance);
            
        }else{
            throw new \Exception("invalid distance set, distance can be array or single numberic [ float | int ] value ");
        }

    }

    public function setPickUpLocation(float $distance_to_pickup):void{
        $this->pick_up_location = $distance_to_pickup;
    }

    public function getPickUpLocation():float{
        return $this->pick_up_location ?? 0;
    }

     /**
     * Get Drop-Off Location
     * 
     * @author Seyi Onifade <xyluz>
     * @return Array
     */ 

    public function getDropOffs():array{
        return $this->drop_offs ?? [];
    }

    /**
     * Set Cost Per Mile Location
     *
     * @param float   $cost  set cost per mile in pounds
     * 
     * @return Void
     */ 

    public function setCostPerMile(float $cost = 1):void{
        $this->cost_per_mile = $cost;
        $this->time_cost_per_mile_set = $this->dateTime();
    }

    /**
     * Get Drop-Off Location
     *
     * @return float
     */ 

    public function getCostPerMile():float{
        return $this->cost_per_mile ?? 0;
    }

    public function setExtraPersonPrice(float $extra = 15):void{
        $this->extra_person_price = $extra;
    }

    /**
     * Get Cost Per Extra Person
     *
     * @return float
     */ 

    public function getExtraPersonPrice():float{
        return $this->extra_person_price ?? 0;
    }

    /**
     * Calculate Total Distance travelled in miles
     *
     * @return float
     */ 


    public function totalDistance():float{

        return array_sum($this->getDropOffs()) ?? 0;

    }

    public function dateTime(){
        return date('m/d/Y h:i:s a', time());
    }

    /**
     * Plot Proposed Travel Route
     *
     * @return Array
     */ 

    public function plotRoute():array{
        //present best route to driver
        return [];
    }

}
