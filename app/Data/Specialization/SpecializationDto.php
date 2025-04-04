<?php
namespace App\Data\Specialization;

use Spatie\LaravelData\Data;


class SpecializationDto extends Data{
    public function __construct(
        public ?string $name,
        public ?string $description
    ){}
}
