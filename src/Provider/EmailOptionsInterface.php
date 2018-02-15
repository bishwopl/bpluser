<?php

namespace BplUser\Provider;

interface EmailOptionsInterface {

    /**
     * Set who the message is to be sent from
     * Used in registration and forgot password email
     * @param string $emailFrom
     */
    public function setEmailFrom($emailFrom);

    /**
     * Get sender email address
     * Used in registration and forgot password email
     */
    public function getEmailFrom();

    /**
     * Set name of sender email address
     * @param string $emailFromName
     */
    public function setEmailFromName($emailFromName);

    /**
     * Get name of sender email address
     */
    public function getEmailFromName();

    /**
     * Set reply to email address
     * @param string $replyTo
     */
    public function setReplyTo($replyTo);

    /**
     * Get reply to email address
     */
    public function getReplyTo();
    
    /**
     * Set smtp options for mailer configuration
     * @param array $smtpOptions
     */
    public function setSmtpOptions($smtpOptions);

    /**
     * Get extra mailer options
     */
    public function getSmtpOptions();
    
    /**
     * Set whether to use smtp configuration or not.
     * If set to false php sendmail function will be used
     * @param bool $flag
     */
    public function setUseSmtp($flag);

    /**
     * Check whether to use smtp configuration or not.
     */
    public function getUseSmtp();
    
    /**
     * Set mailer service factory
     * @param string $mailerServiceFactory
     */
    public function setMailerServiceFactory($mailerServiceFactory);

    /**
     * Get mailer service factory
     */
    public function getMailerServiceFactory();
}
