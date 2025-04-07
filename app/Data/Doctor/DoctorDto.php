<?php
namespace App\Data\Doctor;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;


class DoctorDto extends Data{
    public function __construct(
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
        public ?int $specializationId,
        #[MapInputName('profile_picture')]
        public ?UploadedFile $profilePicture,
        #[MapInputName('profile_picture_path')]
        #[MapOutputName('profile_picture_path')]
        public ?string $profilePicturePath,
        #[MapInputName('is_active')]
        #[MapOutputName('is_active')]
        public ?bool $isActive = true,
    ){}
}
