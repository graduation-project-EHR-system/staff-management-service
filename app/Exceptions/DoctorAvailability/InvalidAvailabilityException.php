<?php

namespace App\Exceptions\DoctorAvailability;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidAvailabilityException extends Exception
{
    //

    // public function __construct(string $message = "Invalid availability", int $code = 400, ?Throwable $previous = null)

    public static function dueToOverlap(): self
    {
        return new self(
            message: 'Doctor already has availability at the same time.',
            code: Response::HTTP_BAD_REQUEST,
        );
    }

    public static function dueToInactiveClinic(): self
    {
        return new self(
            message: 'Clinic is not active.',
            code: Response::HTTP_BAD_REQUEST,
        );
    }

    public static function dueToClinicFull(): self
    {
        return new self(
            message: 'Clinic is full right now.',
            code: Response::HTTP_BAD_REQUEST,
        );
    }
}
