<?php

namespace App\Services;

use App\Repositories\DoctorRepository;
class DoctorService
{
    public function __construct(
        private DoctorRepository $doctorRepository
    ) {}
}
