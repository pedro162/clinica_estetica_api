<?php

namespace App\Application\Commands\WorkOrder;

class DeleteWorkOrderCommand
{
    protected ?string $id = null;

    public function id(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public static function build(array $data): self
    {
        $entity = new self();

        if (isset($data['id'])) {
            $entity->id((string)$data['id']);
        }

        return $entity;
    }

    public function getDataProperties(): array
    {
        $data = [
            'id' => (string)($this->id ?? ''),
        ];

        return array_filter($data, fn ($v) => $v !== '' && $v !== null);
    }
}
