<?php

namespace Matt\SyCaptchaBundle\HCaptcha;

/**
 * Response resolver for hCaptcha
 */
class HCaptchaResponseResolver
{
    /**
     * @var HCaptchaResponse
     */
    private $response;

    /**
     * @var string
     */
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Resolves the hCaptcha token and verifies whether it is, or is not a valid response.
     * @return void
     */
    public function resolveResponse(string $token): HCaptchaResponse
    {
        $hCaptchaResponse = new HCaptchaResponse();
        $hCaptchaResponse->setChallengeTimestamp(new \Symfony\Component\Validator\Constraints\Date());

        if ($this->secretKey === null || $this->secretKey === '') {
            return $hCaptchaResponse;
        }
        if ($token === '') {
            return $hCaptchaResponse;
        }

        $curl = \curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $this->secretKey,
            'response' => $token
        ]));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = \json_decode(\curl_exec($curl));

        if ($response->success) {
            $hCaptchaResponse->setSuccess(true);
        }
        return $hCaptchaResponse;
    }
}