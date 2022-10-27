<?php 

namespace App\class;

use App\interface\User as UserInterface;

class User extends Database implements UserInterface
{
    public function __construct()
    {
        parent::__construct();

        // db connection - if needed
        // authentication check if needed 
        // class access restricted to unauthenticated users

    }

}
