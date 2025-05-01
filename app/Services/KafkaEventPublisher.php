<?php
namespace App\Services;

use App\Enums\KafkaTopic;
use App\Interfaces\EventPublisher;
use Junges\Kafka\Facades\Kafka;

class KafkaEventPublisher implements EventPublisher
{
    protected KafkaTopic $topic;

    protected array $body;

    public static function make(): self
    {
        return new self();
    }

    public function onTopic(KafkaTopic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function withBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function publish(): void
    {
        Kafka::publish()
            ->onTopic($this->topic->value)
            ->withBody($this->constructBody())
            ->send();
    }

    protected function constructBody(): array
    {
        return [
            'timestamp' => now()->toDateTimeString(),
            'data' => $this->body,
        ];
    }
}
