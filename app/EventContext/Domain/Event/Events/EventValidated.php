<?php

declare(strict_types=1);

namespace App\EventContext\Domain\Event\Events;

use App\EventContext\Domain\DomainEvent;
use DateTimeImmutable;

class EventValidated extends DomainEvent
{
    private const NAME = 'event.event.event_validated';

    public static function create(
        string $aggregateId,
        array $metadata = [],
        array $data = []
    ): self {
        return new self(
            uniqid(),
            $aggregateId,
            $metadata,
            $data,
            new DateTimeImmutable()
        );
    }

    public static function getEventName(): string
    {
        return self::NAME;
    }

    public static function getClassName(): string
    {
        return self::class;
    }

    public static function getVersion(): int
    {
        return 1;
    }
}
