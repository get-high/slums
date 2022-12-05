<?php

namespace App\Validator;

use App\Repository\PhotoRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidPhotoValidator extends ConstraintValidator
{
    public function __construct(private PhotoRepository $repository)
    {}

    public function validate($value, Constraint $constraint)
    {
        foreach ($value as $photo) {
            if (! $this->repository->existsById((int)$photo)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $photo)
                    ->addViolation();
            }
        }
    }
}
