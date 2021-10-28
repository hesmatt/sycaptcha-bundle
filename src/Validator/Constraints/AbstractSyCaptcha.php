<?php

namespace Matt\SyCaptchaBundle\Validator\Constraints;

abstract class AbstractSyCaptcha extends \Symfony\Component\Validator\Constraint
{
    const ERROR_CODE = '9945380070',
        ERROR_MESSAGE = 'It looks like your computer or network may be sending automated queries';
}