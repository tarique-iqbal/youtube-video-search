<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Validator;

class ArraySizeValidator
{
    private string $errorMessage;

    public function isValid(array $array, int $inputSize): bool
    {
        if (count($array) !== $inputSize) {
            $this->errorMessage = 'Invalid input length.';

            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
