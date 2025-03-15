<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class DoctorDto implements DTO{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $phone,
        public ?string $password,
        public ?int $specializationId,
        public ?bool $isActive,
        public ?UploadedFile $profilePicture
    ){}

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'specialization_id' => $this->specializationId,
            'is_active' => $this->isActive,
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            firstName : $request->get('first_name'),
            lastName : $request->get('last_name'),
            email : $request->get('email'),
            phone : $request->get('phone'),
            password : $request->get('password'),
            specializationId : $request->get('specialization_id'),
            isActive : $request->get('is_active'),
            profilePicture : $request->get('profile_picture'),
        );
    }
}
