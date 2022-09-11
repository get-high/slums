<?php

namespace App\Validator;


use App\Repository\SpotRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueSpotSlugValidator extends ConstraintValidator
{
    public function __construct(private SpotRepository $repository)
    {}

    public function validate($value, Constraint $constraint)
    {
        if ($this->repository->existsBySlug($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
