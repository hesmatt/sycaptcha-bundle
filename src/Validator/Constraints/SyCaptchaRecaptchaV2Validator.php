<?php

namespace Matt\SyCaptchaBundle\Validator\Constraints;

class SyCaptchaRecaptchaV2Validator extends AbstractSyCaptchaValidator
{
    public function validate($value, \Symfony\Component\Validator\Constraint $constraint)
    {
        if (!$this->enabled) {
            return;
        }

        $this->validateReCaptcha($value, $constraint);
    }

    private function validateReCaptcha(?string $token, \Symfony\Component\Validator\Constraint $constraint)
    {
        if ($token === null || $token === '') {
            $this->denySubmit();
            return;
        }

        $this->lastResponse = $this->recaptcha->verify($token, $this->ipResolver->resolveIpAddress());
        if (!$this->lastResponse->isSuccess()) {
            $this->denySubmit();
        }
    }
}