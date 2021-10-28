<?php

namespace Matt\SyCaptchaBundle\Utilities;

class IpResolver
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    public function __construct(\Symfony\Component\HttpFoundation\RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function resolveIpAddress(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        return ($request !== null) ? $request->getClientIp() : null;
    }
}