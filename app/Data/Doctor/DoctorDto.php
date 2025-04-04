<?php

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;


class DoctorDto extends Data{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $phone,
        public ?string $password,
        public ?int $specializationId,
        public ?bool $isActive,
        public ?UploadedFile $profilePicture,
        public ?string $profilePicturePath
    ){}
}
