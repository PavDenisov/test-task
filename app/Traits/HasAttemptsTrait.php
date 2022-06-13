<?php

namespace App\Traits;

use Exception;

trait HasAttemptsTrait
{
    /**
     * @var int
     */
    private int $attempts = 0;

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     */
    public function setAttempts(int $attempts): void
    {
        $this->attempts = $attempts;
    }

    /**
     * Check attempts for http requests
     *
     * @param string $message
     * @return bool
     * @throws Exception
     */
    public function attemptsCheck(string $message = 'Something goes wrong'): bool
    {
        if ($this->getAttempts() === config('attempts.laravel_blog')) {
            throw new Exception($message);
        }

        return true;
    }
}
