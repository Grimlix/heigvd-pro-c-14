<?php

namespace App\Validator;

use App\Repository\PollRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class TockenValidator extends ConstraintValidator
{
    private $pollRepository;

    public function __construct(PollRepository $pollRepository)
    {
        $this->pollRepository = $pollRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $poll = $this->pollRepository->findOneBy(['passToken' => $value]);

        /* @var $constraint \App\Validator\Tocken */

        if (!$poll ||null === $value || '' === $value) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
            //return;
        }

    }
}
