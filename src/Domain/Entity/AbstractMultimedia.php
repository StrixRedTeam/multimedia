<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Multimedia\Domain\Entity;

use Ergonode\EventSourcing\Domain\AbstractAggregateRoot;
use Ergonode\Multimedia\Domain\Event\MultimediaCreatedEvent;
use Ergonode\Multimedia\Domain\ValueObject\Hash;
use Ergonode\SharedKernel\Domain\Aggregate\MultimediaId;
use Ergonode\Core\Domain\ValueObject\TranslatableString;
use Ergonode\Multimedia\Domain\Event\MultimediaAltChangedEvent;
use Ergonode\Multimedia\Domain\Event\MultimediaNameChangedEvent;
use Ergonode\Multimedia\Domain\Event\MultimediaTitleChangedEvent;

abstract class AbstractMultimedia extends AbstractAggregateRoot
{
    private MultimediaId $id;

    private string $name;

    private string $extension;

    private ?string $mime;

    /**
     * The file size in bytes.
     */
    private int $size;

    /**
     * @deprecated
     */
    private Hash $hash;

    private TranslatableString $title;

    private TranslatableString $alt;

    /**
     * @param int $size The file size in bytes.
     *
     * @throws \Exception
     */
    public function __construct(
        MultimediaId $id,
        string $name,
        string $extension,
        int $size,
        Hash $hash,
        ?string $mime = null
    ) {
        $this->apply(
            new MultimediaCreatedEvent(
                $id,
                $name,
                $extension,
                $size,
                $hash,
                $mime
            )
        );
    }

    public function getFileName(): string
    {
        return sprintf('%s.%s', $this->id->getValue(), $this->extension);
    }

    /**
     * @throws \Exception
     */
    public function changeTitle(TranslatableString $title): void
    {
        if (!$title->isEqual($this->title)) {
            $this->apply(new MultimediaTitleChangedEvent($this->id, $title));
        }
    }

    /**
     * @throws \Exception
     */
    public function changeAlt(TranslatableString $alt): void
    {
        if (!$alt->isEqual($this->alt)) {
            $this->apply(new MultimediaAltChangedEvent($this->id, $alt));
        }
    }

    /**
     * @throws \Exception
     */
    public function changeName(string $name): void
    {
        if ($name !== $this->getName()) {
            $this->apply(new MultimediaNameChangedEvent($this->id, $name));
        }
    }

    public function getId(): MultimediaId
    {
        return $this->id;
    }

    public function getTitle(): TranslatableString
    {
        return $this->title;
    }

    public function getAlt(): TranslatableString
    {
        return $this->alt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @deprecated
     */
    public function getHash(): Hash
    {
        return $this->hash;
    }

    protected function applyMultimediaCreatedEvent(MultimediaCreatedEvent $event): void
    {
        $this->id = $event->getAggregateId();
        $this->name = $event->getName();
        $this->extension = $event->getExtension();
        $this->mime = $event->getMime();
        $this->size = $event->getSize();
        $this->hash = $event->getHash();
        $this->title = new TranslatableString();
        $this->alt = new TranslatableString();
    }

    protected function applyMultimediaTitleChangedEvent(MultimediaTitleChangedEvent $event): void
    {
        $this->title = $event->getTitle();
    }

    protected function applyMultimediaAltChangedEvent(MultimediaAltChangedEvent $event): void
    {
        $this->alt = $event->getAlt();
    }

    protected function applyMultimediaNameChangedEvent(MultimediaNameChangedEvent $event): void
    {
        $this->name = $event->getName();
    }
}
