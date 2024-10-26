<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Validator;

class SearchKeywordValidator
{
    private string $errorMessage;

    public function isValid(string $keyword): bool
    {
        if ($keyword === '') {
            $this->errorMessage = 'Search keyword can not be empty.';

            return false;
        }

        if (!preg_match('/[a-zA-Z]+$/', $keyword)) {
            $this->errorMessage = 'Search keyword should contain alphabets.';

            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
