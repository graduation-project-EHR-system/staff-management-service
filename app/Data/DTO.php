<?php
namespace App\Data;

use Illuminate\Http\Request;


interface DTO {
    public function toArray() : array;

    public static function fromRequest(Request $request) : self;

    public static function fromArray(array $data) : self;
}
