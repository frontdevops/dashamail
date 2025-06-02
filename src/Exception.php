<?php declare(strict_types=1);

namespace DashaMail
{
  use RuntimeException;
  use Throwable;

  final class Exception extends RuntimeException
  {
      public function __construct(
          string $message,
          public ?array $response = null,
          int $code = 0,
          ?Throwable $previous = null,
      )
      {
          parent::__construct($message, $code, $previous);
      }
  }
}

#EOF#
