<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class Dimensions extends Data
{
    public function __construct(
        public int $width,
        public int $height,
        public int $x,
        public int $y,
    ) {}
}
