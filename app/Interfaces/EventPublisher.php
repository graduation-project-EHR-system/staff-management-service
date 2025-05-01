<?php

namespace App\Interfaces;

use App\Enums\KafkaTopic;

interface EventPublisher
{
    public static function make(): self;

    public function onTopic(KafkaTopic $topic): self;

    public function withBody(array $body): self;

    public function publish(): void;
}
