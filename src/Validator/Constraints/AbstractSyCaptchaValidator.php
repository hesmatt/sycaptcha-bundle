<?php

namespace Matt\SyCaptchaBundle\Validator\Constraints;

abstract class AbstractSyCaptchaValidator extends \Symfony\Component\Validator\ConstraintValidator
{
    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var \ReCaptcha\ReCaptcha
     */
    protected $recaptcha;

    /**
     * @var \Matt\SyCaptchaBundle\Utilities\IpResolver
     */
    protected $ipResolver;

    /**
     * @var \ReCaptcha\Response|string|null
     */
    public $lastResponse;

    public function __construct(\ReCaptcha\ReCaptcha $reCaptcha, bool $enabled, \Matt\SyCaptchaBundle\Utilities\IpResolver $ipResolver)
    {
        $this->enabled = $enabled;
        $this->recaptcha = $reCaptcha;
        $this->ipResolver = $ipResolver;
    }

    protected function denySubmit(): void
    {
        $this->context->buildViolation(AbstractSyCaptcha::ERROR_MESSAGE)
            ->setCode(AbstractSyCaptcha::ERROR_CODE)
            ->addViolation();
    }

    /**
     * @return \ReCaptcha\Response|string|null
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}