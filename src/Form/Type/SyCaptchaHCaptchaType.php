<?php

namespace Matt\SyCaptchaBundle\Form\Type;

/**
 * Type for hCaptcha
 */
class SyCaptchaHCaptchaType extends AbstractSyCaptchaType
{
    /**
     * @var bool
     */
    private $invisible;

    public function __construct(?string $siteKey, ?bool $enabled, ?string $apiHost = 'js.hcaptcha.com', ?bool $invisible = false)
    {
        parent::__construct($siteKey, $enabled, $apiHost);
        if ($invisible === null) {
            throw new \Exception('Missing one of the required keys for captcha rendering');
        }
        $this->invisible = $invisible;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'label' => false,
            'constraints' => [
                new \Matt\SyCaptchaBundle\Validator\Constraints\SyCaptchaHCaptcha()
            ],
            'theme' => 'light',
            'script_nonce_csp' => null
        ]);
    }

    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $view->vars['captcha_type'] = 'hCaptcha';
        $view->vars['invisible'] = $this->invisible;
        $view->vars['theme'] = $options['theme'];
    }

    public function getBlockPrefix(): string
    {
        return 'sy_captcha_hcaptcha';
    }
}