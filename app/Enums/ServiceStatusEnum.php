<?php
namespace App\Enums;
 
enum ServiceStatusEnum:int {
    case INPROCESS = 1;
    case RECEIVED= 2;
    case ATTENDED = 3;
    case RELEASED = 4;
    case APPROVED = 5;
    case CANCELLED = 6;    

}