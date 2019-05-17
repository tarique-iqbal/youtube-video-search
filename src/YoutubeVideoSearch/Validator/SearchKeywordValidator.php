<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Validator;

/**
 * Class SearchKeyWorkValidator
 * @package YoutubeVideoSearch\Validator
 */
class SearchKeywordValidator
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $keyword
     * @return bool
     */
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

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
