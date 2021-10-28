<?php

namespace Matt\SyCaptchaBundle\Form\Type;

/**
 * Type for reCaptcha V2
 */
class SyCaptchaRecaptchaV2Type extends AbstractSyCaptchaType
{
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'label' => false,
            'constraints' => [
                new \Matt\SyCaptchaBundle\Validator\Constraints\SyCaptchaRecaptchaV2()
            ],
            'script_nonce_csp' => null,
            'theme' => 'light'
        ]);
    }

    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $view->vars['captcha_type'] = 'V2';
        $view->vars['theme'] = $options['theme'];
    }

    public function getBlockPrefix(): string
    {
        return 'sy_captcha_recaptcha_v2';
    }
}