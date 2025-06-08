<?php
namespace App\Data\Nurse;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class NurseDto extends Data
{
    public function __construct(
        #[StringType, Max(255)]
        public Optional|string $national_id,

        #[StringType, Max(255)]
        public Optional|string $first_name,

        #[StringType, Max(255)]
        public Optional|string $last_name,

        #[Email, Max(255)]
        public Optional|string $email,

        #[StringType, Max(255)]
        public Optional|string $phone,

        #[BooleanType]
        public Optional|bool $is_active,

        #[Uuid]
        public Optional|string $clinic_id,
    ) {
    }
}
