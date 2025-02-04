<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Multimedia\Domain\Command;

use Ergonode\SharedKernel\Domain\Aggregate\MultimediaId;
use Ergonode\Core\Domain\ValueObject\TranslatableString;

class UpdateMultimediaCommand implements MultimediaCommandInterface
{
    private MultimediaId $id;

    private string $name;

    private TranslatableString $alt;

    private TranslatableString $title;

    public function __construct(MultimediaId $id, string $name, TranslatableString $alt, TranslatableString $title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->alt = $alt;
        $this->title = $title;
    }

    public function getId(): MultimediaId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlt(): TranslatableString
    {
        return $this->alt;
    }

    public function getTitle(): TranslatableString
    {
        return $this->title;
    }
}
