<?php

use Illuminate\Http\Request;


class SpecializationDto implements DTO{
    public function __construct(
        public ?string $name,
        public ?string $description
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

    public static function fromRequest(Request $request) : self
    {
        return new self(
            name: $request->get('name'),
            description : $request->get('description')
        );
    }
}
