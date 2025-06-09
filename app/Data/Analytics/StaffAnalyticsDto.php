<?php

namespace App\Data\Analytics;

class StaffAnalyticsDto{
    public function __construct(
        public int $numberOfDoctors,
        public int $numberOfNurses,
        public int $numberOfSpecializations,
        public int $numberOfReceptionists
    ){}
}
