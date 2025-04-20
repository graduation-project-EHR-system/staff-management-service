<?php

namespace App\Enums;

enum KafkaTopic: string
{
    case DOCTORS_CREATE = 'doctors.create';
    case DOCTORS_UPDATE = 'doctors.update';
    case DOCTORS_DELETE = 'doctors.delete';
}
