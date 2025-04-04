<?php
namespace App\Data\Clinic;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class ClinicDto extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        #[MapInputName('current_doctors')]
        #[MapOutputName('current_doctors')]
        public ?int $currentDoctors = 0,
        #[MapInputName('max_doctors')]
        #[MapOutputName('max_doctors')]
        public ?int $maxDoctors = 0,
        #[MapInputName('is_active')]
        #[MapOutputName('is_active')]
        public ?bool $isActive = true
    ) {}
}
