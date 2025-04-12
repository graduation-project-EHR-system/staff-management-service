<?php
namespace App\Data\Specialization;

use App\Enums\SpecializationColor;
use Spatie\LaravelData\Data;


class SpecializationDto extends Data{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?SpecializationColor $color
    ){}
}
