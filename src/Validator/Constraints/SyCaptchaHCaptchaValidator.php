<?php

namespace Matt\SyCaptchaBundle\Validator\Constraints;

class SyCaptchaHCaptchaValidator extends AbstractSyCaptchaValidator
{
    /**
     * @var \Matt\SyCaptchaBundle\HCaptcha\HCaptchaResponseResolver
     */
    private $hCaptchaResponseResolver;

    public function __construct(bool $enabled, \Matt\SyCaptchaBundle\Utilities\IpResolver $ipResolver, \Matt\SyCaptchaBundle\HCaptcha\HCaptchaResponseResolver $hCaptchaResponseResolver)
    {
        parent::__construct(null, $enabled, $ipResolver);
        $this->hCaptchaResponseResolver = $hCaptchaResponseResolver;
    }

    public function validate($value, \Symfony\Component\Validator\Constraint $constraint)
    {
        if (!$this->enabled) {
            return;
        }

        $this->validateHCaptcha($value, $constraint);
    }

    private function validateHCaptcha(?string $token, \Symfony\Component\Validator\Constraint $constraint)
    {
        if ($token === null || $token === '') {
            $this->denySubmit();
            return;
        }

        $this->lastResponse = $this->hCaptchaResponseResolver->resolveResponse($token);
        if (!$this->lastResponse->isSuccess()) {
            $this->denySubmit();
        }
    }
}