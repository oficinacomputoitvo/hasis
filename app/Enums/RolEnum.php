<?php
namespace App\Enums;
 
enum RolEnum:int {
    case ADMIN = 1;
    case COLLABORATOR = 2;
    case REQUESTER = 3;
    case APPROVER= 4;
}

