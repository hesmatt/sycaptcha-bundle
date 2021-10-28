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
     * @var \DateTimeImmutable
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
     * @param \DateTimeImmutable $challengeTimestamp
     */
    public function setChallengeTimestamp(\DateTimeImmutable $challengeTimestamp): void
    {
        $this->challengeTimestamp = $challengeTimestamp;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getChallengeTimestamp(): \DateTimeImmutable
    {
        return $this->challengeTimestamp;
    }
}