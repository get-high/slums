<?php

namespace App\Validator;

use App\Repository\SpotRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueSpotValidator extends ConstraintValidator
{
    private SpotRepository $spotRepository;

    public function __construct(SpotRepository $spotRepository)
    {
        $this->spotRepository = $spotRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\UniqueSpot $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (! $this->spotRepository->findOneBy(['slug' => $value])) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
