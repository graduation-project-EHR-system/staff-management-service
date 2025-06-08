<?php
namespace App\Data\Doctor;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;


class DoctorDto extends Data{
    public function __construct(
        #[MapInputName('national_id')]
        #[MapOutputName('national_id')]
        public ?string $nationalId,
        #[MapInputName('first_name')]
        #[MapOutputName('first_name')]
        public ?string $firstName,
        #[MapInputName('last_name')]
        #[MapOutputName('last_name')]
        public ?string $lastName,
        public ?string $email,
        public ?string $phone,
        #[MapInputName('specialization_id')]
        #[MapOutputName('specialization_id')]
        public ?string $specializationId,
        #[MapInputName('is_active')]
        #[MapOutputName('is_active')]
        public ?bool $isActive = true,
    ){}
}
