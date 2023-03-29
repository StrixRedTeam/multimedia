<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Multimedia\Application\Validator;

use Ergonode\Multimedia\Application\Model\MultimediaModel;
use Ergonode\Multimedia\Application\Model\MultimediaUploadModel;
use Ergonode\Multimedia\Domain\Query\MultimediaQueryInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class MultimediaUploadNameExistsValidator extends ConstraintValidator
{
    private MultimediaQueryInterface $multimediaQuery;

    public function __construct(
        MultimediaQueryInterface $multimediaQuery
    ) {
        $this->multimediaQuery = $multimediaQuery;
    }

    /**
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MultimediaUploadNameExists) {
            throw new UnexpectedTypeException($constraint, MultimediaUploadNameExists::class);
        }

        if (!$value instanceof UploadedFile) {
            throw new UnexpectedValueException($value, MultimediaUploadModel::class);
        }

        if (null === $value->getClientOriginalName()) {
            return;
        }

        $name = substr($value->getClientOriginalName(), 0, strrpos($value->getClientOriginalName(), "."));;
        if ($this->multimediaQuery->findIdByFilenameOnly($name)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $name)
                ->atPath('name')
                ->addViolation();
        }
    }
}
