<?php
namespace App\Enums;


enum StoragePath : string {
    case DOCTOR_PROFILE_PICTURES = 'doctors/profile_pictrues';

    public function getFullPath(): string
    {
        return match($this){
            self::DOCTOR_PROFILE_PICTURES => 'public' . $this->value
        };
    }
}
