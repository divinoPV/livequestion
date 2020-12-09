<?php

namespace App\Util;

use Psr\Log\LoggerInterface;

final class Logger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(\Exception $exception,
                        string $location,
                        string $action,
                        array $context = []): void
    {
        $this->logger->error('ERREUR - '.$location.' - '.$action, [
            'exception' => $exception,
            'context' => $context
        ]);
    }
}