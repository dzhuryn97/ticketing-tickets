<?php

namespace App\Presenter;

use Symfony\Component\Validator\Constraints\NotBlank;

class TestRequest
{
    public function __construct(
        #[NotBlank(
            allowNull: true
        )]
        public ?string $name = '',
    ) {
    }
}
