<?php

declare(strict_types=1);

namespace Ergonode\Migration;

use Doctrine\DBAL\Schema\Schema;
use Ergonode\Multimedia\Domain\Event\MultimediaTitleChangedEvent;
use Ramsey\Uuid\Uuid;

final class Version20221124131712 extends AbstractErgonodeMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
            'INSERT INTO event_store_event (id, event_class, translation_key) VALUES (?,?,?)',
            [
                Uuid::uuid4()->toString(),
                MultimediaTitleChangedEvent::class,
                'Multimedia title changed'
            ]
        );
    }
}
