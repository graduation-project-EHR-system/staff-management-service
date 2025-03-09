<?php

namespace App\Services;

use App\Repositories\SpecializationRepository;
class SpecializationService
{
    public function __construct(
        private SpecializationRepository $specializationRepository
    ) {}
}
