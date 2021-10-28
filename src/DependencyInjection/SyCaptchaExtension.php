<?php

namespace Matt\SyCaptchaBundle\DependencyInjection;

/**
 * Class that loads and manages all configurations for this bundle.
 */
class SyCaptchaExtension extends \Symfony\Component\DependencyInjection\Extension\Extension implements \Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, \Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader(
            $container,
            new \Symfony\Component\Config\FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
        $this->loadRecaptchaV2Parameters($container, $config);
        $this->loadRecaptchaV3Parameters($container, $config);
        $this->loadHCaptchaParameters($container, $config);

        foreach ($config as $configKey => $configValue) {
            if ($configKey !== 'hcaptcha' && $configKey !== 'recaptcha_v2' && $configKey !== 'recaptcha_v3') {
                $container->setParameter("sy_captcha.{$configKey}", $configValue);
            }
        }
    }

    private function loadRecaptchaV2Parameters(\Symfony\Component\DependencyInjection\ContainerBuilder $container, array $config)
    {
        $parametersToSet = [
            'sy_captcha.recaptcha_v2.site_key' => null,
            'sy_captcha.recaptcha_v2.secret_key' => null,
            'sy_captcha.recaptcha_v2.api_host' => 'www.google.com'
        ];

        if (isset($config['recaptcha_v2'])) {
            if (isset($config['recaptcha_v2']['site_key']) || $config['recaptcha_v2']['site_key'] == null) {
                $parametersToSet['sy_captcha.recaptcha_v2.site_key'] = $config['recaptcha_v2']['site_key'];
            }
            if (isset($config['recaptcha_v2']['secret_key']) || $config['recaptcha_v2']['secret_key'] == null) {
                $parametersToSet['sy_captcha.recaptcha_v2.secret_key'] = $config['recaptcha_v2']['secret_key'];
            }
            if (isset($config['recaptcha_v2']['api_host'])) {
                $parametersToSet['sy_captcha.recaptcha_v2.api_host'] = $config['recaptcha_v2']['api_host'];
            }
        }
        $this->setParametersByArray($container, $parametersToSet);
    }

    private function loadRecaptchaV3Parameters(\Symfony\Component\DependencyInjection\ContainerBuilder $container, array $config)
    {
        $parametersToSet = [
            'sy_captcha.recaptcha_v3.site_key' => null,
            'sy_captcha.recaptcha_v3.secret_key' => null,
            'sy_captcha.recaptcha_v3.api_host' => 'www.google.com',
            'sy_captcha.recaptcha_v3.score_threshold' => 0.5
        ];

        if (isset($config['recaptcha_v3'])) {
            if (isset($config['recaptcha_v3']['site_key']) || $config['recaptcha_v3']['site_key'] == null) {
                $parametersToSet['sy_captcha.recaptcha_v3.site_key'] = $config['recaptcha_v3']['site_key'];
            }
            if (isset($config['recaptcha_v3']['secret_key']) || $config['recaptcha_v3']['secret_key'] == null) {
                $parametersToSet['sy_captcha.recaptcha_v3.secret_key'] = $config['recaptcha_v3']['secret_key'];
            }
            if (isset($config['recaptcha_v3']['api_host'])) {
                $parametersToSet['sy_captcha.recaptcha_v3.api_host'] = $config['recaptcha_v3']['api_host'];
            }
            if (isset($config['recaptcha_v3']['score_threshold'])) {
                $parametersToSet['sy_captcha.recaptcha_v3.score_threshold'] = $config['recaptcha_v3']['score_threshold'];
            }
        }
        $this->setParametersByArray($container, $parametersToSet);
    }

    private function loadHCaptchaParameters(\Symfony\Component\DependencyInjection\ContainerBuilder $container, array $config)
    {
        $parametersToSet = [
            'sy_captcha.hcaptcha.site_key' => null,
            'sy_captcha.hcaptcha.secret_key' => null,
            'sy_captcha.hcaptcha.api_host' => 'js.hcaptcha.com',
            'sy_captcha.hcaptcha.invisible' => false
        ];

        if (isset($config['hcaptcha'])) {
            if (isset($config['hcaptcha']['site_key']) || $config['hcaptcha']['site_key'] == null) {
                $parametersToSet['sy_captcha.hcaptcha.site_key'] = $config['hcaptcha']['site_key'];
            }
            if (isset($config['hcaptcha']['secret_key']) || $config['hcaptcha']['secret_key'] == null) {
                $parametersToSet['sy_captcha.hcaptcha.secret_key'] = $config['hcaptcha']['secret_key'];
            }
            if (isset($config['hcaptcha']['api_host'])) {
                $parametersToSet['sy_captcha.hcaptcha.api_host'] = $config['hcaptcha']['api_host'];
            }
            if (isset($config['hcaptcha']['invisible'])) {
                $parametersToSet['sy_captcha.hcaptcha.invisible'] = $config['hcaptcha']['invisible'];
            }
        }
        $this->setParametersByArray($container, $parametersToSet);
    }

    private function setParametersByArray(\Symfony\Component\DependencyInjection\ContainerBuilder $container, array $parameters): void
    {
        foreach ($parameters as $parameterKey => $parameterValue) {
            $container->setParameter($parameterKey, $parameterValue);
        }
    }

    /**
     * Prepends twig form themes to include custom widget
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @return void
     */
    public function prepend(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        //TODO: Implement logic into twig to render based off of a version
        $container->prependExtensionConfig('twig', ['form_themes' => ['@SyCaptcha/Form/sy_captcha_widget.html.twig']]);
    }
}
