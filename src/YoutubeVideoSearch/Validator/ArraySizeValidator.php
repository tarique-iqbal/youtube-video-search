<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Validator;

/**
 * Class ArraySizeValidator
 * @package LanguageGroup\Validator
 */
class ArraySizeValidator
{
    /**
     * @var string
     */
    private string $errorMessage;

    /**
     * @param array $array
     * @param int $inputSize
     * @return bool
     */
    public function isValid(array $array, int $inputSize): bool
    {
        if (count($array) !== $inputSize) {
            $this->errorMessage = 'Invalid input length.';

            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
