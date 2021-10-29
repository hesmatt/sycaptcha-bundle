# SyCaptchaBundle

SyCaptchaBundle is a form protection bundle made for **Symfony**, including a set of CAPTCHA challenges that should stop any malicious requests from submitting your forms.


## Supported CAPTCHAs
There are **three** types of supported CAPTCHAs as of now
1. **reCaptcha V2** - By Google
2. **reCaptcha V3** - By Google
3. **hCaptcha** - By Intuition Machines

Invisible reCaptcha V2 **isn't** supported, due to the fact that it's 'lower' end version of reCaptcha V3

## Installation

With [composer](https://getcomposer.org/) require

`require matt/sycaptcha`


## Configuration without symfony/flex

You can configure all the needed files manually when not having an option to install/upgrade to [symfony/flex](https://github.com/symfony/flex)

### 1. Register the bundle
Register bundle into `config/bundles.php` **Symfony 4/5**

    return [
	    Matt\SyCaptchaBundle\SyCaptchaBundle::class => ['all' => true],
    ];

Register bundle into `app/AppKernel.php` **Symfony 3 and below**

    public function registerBundles()
	{
	    return [
	        new Matt\SyCaptchaBundle\SyCaptchaBundle(),
	    ];
	}
### 2. Add configuration files
`config/packages/sy_captcha.yaml (or app/config/config.yml if using Symfony 3 or below)`

    sy_captcha:  
	  recaptcha_v2:  
	    site_key: 'site_key'  
	    secret_key: 'secret_key'  

## Usage

Let's finally get to the part about how you can integrate those CAPTCHAS into your forms.

### 1. Create form and add the CAPTCHA protection
You can add all three CAPTCHAS into the form at the same time (yes, it's overkill), however, they all need to be configured properly

    <?php  
    
	use Matt\SyCaptchaBundle\Form\Type\SyCaptchaHCaptchaType;  
	
	class FormType extends AbstractType  
	{  
	  public function buildForm(FormBuilderInterface $builder, array $options): void  
	  {  
		  $builder->add('captcha', SyCaptchaHCaptchaType::class);
	  }  
	}

### 2. Configure the CAPTCHA if needed
There are series of parameters that can be used to configure the CAPTCHA and it's scripts.
Most of them are being set via configuration file (more in whole configuration section) but few of them are being declared via form options. Those are

1. **action_name** - Sets the action name (**reCaptcha V3 Only**)
2. **theme** - Sets the CAPTCHA theme to either light / dark (**reCaptcha V2 and hCaptcha Only**)
3. **script_nonce_csp** - Sets the nonce of all scripts injected via CAPTCHA widget

## Full config explanation
The whole config looks like this now

    sy_captcha:  
	  enabled: true  
	  recaptcha_v2:  
	    site_key: null  
	    secret_key: null  
	    api_host: 'www.google.com'  
	  recaptcha_v3:  
	    site_key: null  
	    secret_key: null  
	    api_host: 'www.google.com'  
		score_threshold: 0.5  
	  hcaptcha:  
	    site_key: null  
	    secret_key: null  
	    api_host: 'js.hcaptcha.com'  
		invisible: false

As you can see there are few configurable options, and their default values.
Let's break the script a little, please note that some options are only available for hCaptcha, some for reCaptcha only and so forth.

- **enabled** - Defines whether the CAPTCHA verification is, or is not enabled can be used to (for example) disable whole page verification on DEV
- **site_key** - This is the value you receive via your reCaptcha or hCaptcha dashboard, it represents the public key of your site
- **secret_key** - This is the value you receive via your reCaptcha or hCaptcha dashboard, it represents the secret key of your website, that's used to check the response
- **score_threshold** - reCaptcha V3 sends users score via the response as well, setting score_threshold to lower than **0.5** will make it even harder for bots (but for people as well) to pass this CAPTCHA
- **api_host** - Can be used to enable CAPTCHAs worldwide, you can not access **www.google.com** in China, thus their CAPTCHA would not work there as well, that's why you'd need to set it to **www.recaptcha.net**

## Including .ENV values into config
This is just a little tip, but you can include .ENV values in your Symfony config. All you need to do is to reference it via `%env(VARIABLE)%` tag in your config.

    sy_captcha:
	    enabled: '%env(SYCAPTCHA_ENABLED)%'
## TODO
A little list of plans for the future

- **Cloudflare IP resolution**, (implementing resolved interface)
- **Translations**
- **Custom styles**  (meaning .css styles)
