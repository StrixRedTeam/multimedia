<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Multimedia\Application\Model;

use Ergonode\Multimedia\Application\Validator\MultimediaFileExists;
use Ergonode\Multimedia\Application\Validator\MultimediaUploadNameExists;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Ergonode\Multimedia\Application\Validator\MultimediaExtension;
use Ergonode\Multimedia\Application\Validator\MultimediaUploadName;

/**
 * @Vich\Uploadable()
 */
class MultimediaUploadModel
{
    /**
     * @Assert\File(maxSize="100M")
     *
     * @Vich\UploadableField(mapping="attachment", fileNameProperty="fileName", size="fileSize")
     *
     * @MultimediaExtension()
     *
     * @MultimediaUploadName()
     *
     * @MultimediaUploadNameExists()
     *
     * @MultimediaFileExists()
     */
    public ?UploadedFile $upload;

    public function __construct()
    {
        $this->upload = null;
    }
}
