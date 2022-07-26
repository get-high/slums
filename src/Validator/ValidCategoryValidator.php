<?php

namespace App\Validator;

use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidCategoryValidator extends ConstraintValidator
{
    public function __construct(private CategoryRepository $repository)
    {}

    public function validate($value, Constraint $constraint)
    {
        foreach ($value as $category) {
            if (! $this->repository->existsById((int)$category)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $category)
                    ->addViolation();
            }
        }
    }
}
