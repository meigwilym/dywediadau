<?php

namespace App\Classes;

class Sayings {

    protected $sayings = [];
    
    public function __construct(array $sayings)
    {
        $this->sayings = $sayings;
    }
    
    public function getRandom(): String
    {
        $key = array_rand($this->sayings);
        
        return $this->sayings[$key];
    }

}