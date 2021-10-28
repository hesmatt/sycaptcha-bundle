<?php

namespace Matt\SyCaptchaBundle\Validator\Constraints;

class SyCaptchaRecaptchaV3Validator extends AbstractSyCaptchaValidator
{
    /**
     * @var float
     */
    private $scoreThreshold;

    public function __construct(\ReCaptcha\ReCaptcha $reCaptcha, bool $enabled, \Matt\SyCaptchaBundle\Utilities\IpResolver $ipResolver, float $scoreThreshold)
    {
        parent::__construct($reCaptcha, $enabled, $ipResolver);
        $this->scoreThreshold = $scoreThreshold;
    }

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
        if (!$this->lastResponse->isSuccess() || $this->lastResponse->getScore() < $this->scoreThreshold) {
            $this->denySubmit();
        }
    }
}