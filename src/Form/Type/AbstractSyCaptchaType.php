<?php

namespace Matt\SyCaptchaBundle\Form\Type;

abstract class AbstractSyCaptchaType extends \Symfony\Component\Form\AbstractType
{
    /**
     * @var string
     */
    protected $siteKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $apiHost;

    /**
     * Defines whether to display or not to display a captcha
     * @var bool
     */
    protected $enabled;


    public function __construct(?string $siteKey, ?bool $enabled, ?string $apiHost = 'www.google.com')
    {
        if ($siteKey === null || $enabled === null || $apiHost === null) {
            throw new \Exception('Missing one of the required keys for captcha rendering');
        }

        $this->siteKey = $siteKey;
        $this->enabled = $enabled;
        $this->apiHost = $apiHost;
    }

    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options): void
    {
        $additionalVariables = [
            'site_key' => $this->siteKey,
            'api_host' => $this->apiHost,
            'enabled' => $this->enabled,
            'callback_id' => \uniqid(),
            'script_nonce_csp' => $options['script_nonce_csp']
        ];

        $view->vars = \array_merge($view->vars, $additionalVariables);
    }

    public function getParent(): string
    {
        return \Symfony\Component\Form\Extension\Core\Type\HiddenType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sy_captcha';
    }
}