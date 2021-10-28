<?php

namespace Matt\SyCaptchaBundle\HCaptcha;

/**
 * Class for hCaptcha response
 */
class HCaptchaResponse
{
    /**
     * @var bool
     */
    public $success = false;

    /**
     * @var \Symfony\Component\Validator\Constraints\Date
     */
    public $challengeTimestamp;

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param \Symfony\Component\Validator\Constraints\Date $challengeTimestamp
     */
    public function setChallengeTimestamp(\Symfony\Component\Validator\Constraints\Date $challengeTimestamp): void
    {
        $this->challengeTimestamp = $challengeTimestamp;
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Date
     */
    public function getChallengeTimestamp(): \Symfony\Component\Validator\Constraints\Date
    {
        return $this->challengeTimestamp;
    }
}