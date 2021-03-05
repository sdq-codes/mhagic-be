<?php

namespace App\Traits;

use App\Exceptions\ResourceNotFoundException;

trait ExceptionsHandlers {
    public function checkIfResourceFound($value, $message) {
        if (!$value || is_null($value) || $value === []) {
            throw new ResourceNotFoundException($message);
        }
    }
}
