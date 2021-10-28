<?php

namespace Matt\SyCaptchaBundle\Form\Type;

/**
 * Type for reCaptcha V3
 */
class SyCaptchaRecaptchaV3Type extends AbstractSyCaptchaType
{
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'label' => false,
            'constraints' => [
                new \Matt\SyCaptchaBundle\Validator\Constraints\SyCaptchaRecaptchaV3()
            ],
            'action_name' => 'form',
            'script_nonce_csp' => null,
        ]);
    }

    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $view->vars['captcha_type'] = 'V3';
        $view->vars['action_name'] = $options['action_name'];
    }

    public function getBlockPrefix(): string
    {
        return 'sy_captcha_recaptcha_v3';
    }
}