<?php
namespace App\Data\Specialization;

use App\Data\DTO;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;


class SpecializationDto extends Data{
    public function __construct(
        public ?string $name,
        public ?string $description
    ){}
}
