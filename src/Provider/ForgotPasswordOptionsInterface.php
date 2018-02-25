<?php

namespace BplUser\Provider;

interface ForgotPasswordOptionsInterface {

    /**
     * Set reset expire time after which reset password request is made invalid
     * (in seconds)
     * @param int $resetExpireTime
     */
    public function setResetExpire($resetExpireTime);

    /**
     * get reset expire time after which reset password request is made invalid
     */
    public function getResetExpire();

    /**
     * Set forgot password email template
     * @param string $template
     */
    public function setForgotPasswordEmailTemplate($template);

    /**
     * get forgot password email template
     */
    public function getForgotPasswordEmailTemplate();

    /**
     * Set subject line of email notification of forgot password request
     * @param string $subject
     */
    public function setForgotPasswordEmailSubjectLine($subject);

    /**
     * Get subject line of email notification of forgot password request
     */
    public function getForgotPasswordEmailSubjectLine();
}
