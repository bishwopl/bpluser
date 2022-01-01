<?php

namespace BplUser\Service;

use Laminas\View\Renderer\RendererInterface;
use Laminas\Math\Rand;
use BplUser\Contract\BplUserInterface;
use CirclicalUser\Provider\UserProviderInterface;
use CirclicalUser\Provider\RoleProviderInterface;
use BplUser\Contract\UserServiceOptionsInterface;
use BplUser\Contract\BplUserServiceInterface;
use BplUser\Contract\UserPasswordResetMapperInterface;
use BplUser\Contract\UserPasswordResetInterface;

class BplUserService implements BplUserServiceInterface {

    /**
     * @var \BplUser\Contract\UserServiceOptionsInterface
     */
    protected $options;
    
    /**
     * @var \CirclicalUser\Provider\UserProviderInterface
     */
    protected $userMapper;

    /**
     * @var \CirclicalUser\Provider\RoleProviderInterface
     */
    protected $roleMapper;

    /**
     * @var \BplUser\Contract\UserPasswordResetMapperInterface
     */
    protected $passwordResetMapper;

    /**
     *
     * @var \PHPMailer 
     */
    protected $mailer;

    /**
     *
     * @var \Laminas\View\Renderer\RendererInterface 
     */
    protected $viewRenderer;

    public function __construct(
    UserServiceOptionsInterface $options, 
    UserProviderInterface $userMapper, 
    RoleProviderInterface $roleMapper, 
    UserPasswordResetMapperInterface $passwordResetMapper, 
    RendererInterface $viewRenderer) {
        $this->options = $options;
        $this->userMapper = $userMapper;
        $this->roleMapper = $roleMapper;
        $this->viewRenderer = $viewRenderer;
        $this->passwordResetMapper = $passwordResetMapper;
        $this->mailer = NULL;
    }

    /**
     * {@inheritDoc}
     */
    public function register(BplUserInterface $user) {
        if ($this->userMapper->findByEmail($user->getEmail()) !== NULL) {
            throw new \Exception('Email Address already in use!');
        }
        $user->setState($this->options->getDefaultUserState());
        $this->userMapper->update($user);
        return $this->userMapper->findByEmail($user->getEmail());
    }

    /**
     * {@inheritDoc}
     */
    public function addDefaultRoles(BplUserInterface $user) {
        $roleAdded = false;
        $roles = $this->options->getDefaultUserRoles();
        foreach ($roles as $r) {
            $roleObject = $this->roleMapper->getRoleWithName($r);
            if ($roleObject !== NULL) {
                $user->addRole($roleObject);
                $roleAdded = true;
            }
        }
        if ($roleAdded) {
            $this->userMapper->update($user);
        }
        return;
    }

    /**
     * {@inheritDoc}
     */
    public function sendRegistrationSuccessEmail(BplUserInterface $user) {
        $this->getMailer();
        $this->mailer->addAddress($user->getEmail());
        $this->mailer->Subject = $this->options->getRegistrationEmailSubjectLine();

        $resetEntity = false;
        if ($this->options->getEnableEmailVerification()) {
            $resetEntity = $this->createPassworResetRecord($user);
        }

        $messageHtml = $this->getHtmlFromLayout(
                $this->options->getRegistrationEmailTemplate(), [
            'user' => $user,
            'resetEntity' => $resetEntity
                ]
        );
        $this->mailer->msgHTML($messageHtml);
        $this->mailer->send();
    }

    /**
     * {@inheritDoc}
     */
    public function sendPasswordResetEmail(string $email) {
        $ret = NULL;
        $user = $this->userMapper->findByEmail($email);
        if ($user instanceof BplUserInterface) {
            try {
                $resetEntity = $this->createPassworResetRecord($user);
                $this->getMailer();
                $this->mailer->addAddress($user->getEmail());
                $this->mailer->Subject = $this->options->getForgotPasswordEmailSubjectLine();
                $messageHtml = $this->getHtmlFromLayout(
                        $this->options->getForgotPasswordEmailTemplate(), [
                    'user' => $user,
                    'resetEntity' => $resetEntity
                        ]
                );
                $this->mailer->msgHTML($messageHtml);
                $this->mailer->send();

                $ret = true;
            } catch (\Exception $ex) {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * {@inheritDoc}
     */
    public function getResetRecord(int $userId, string $token) {
        $this->passwordResetMapper->removeOlderRequests($this->options->getResetExpire());
        return $this->passwordResetMapper->getResetRecordByUseIdToken($userId, $token);
    }

    /**
     * {@inheritDoc}
     */
    public function removePreviousResetRequests(int $userId) {
        $this->passwordResetMapper->removeByUserId($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function cleanExpiredForgotRequests() {
        $this->passwordResetMapper->removeOlderRequests($this->options->getResetExpire());
    }

    /**
     * Returns password reset record for $user
     * Deletes older requests for the same user
     * @param BplUserInterface $user
     * @return UserPasswordResetInterface
     */
    protected function createPassworResetRecord(BplUserInterface $user) {
        $this->passwordResetMapper->removeByUserId($user->getId());
        $resetEntity = $this->passwordResetMapper->getEntity();
        $resetEntity->setUser($user);
        $resetEntity->setRequestTime(new \DateTime());
        $resetEntity->setRequestKey($this->getRandomString());
        $this->passwordResetMapper->savePasswordResetRequestRecord($resetEntity);
        return $resetEntity;
    }

    /**
     * Create HTML from layout and parameter
     * @param string $layout
     * @param array $params
     * @param bool $isTerminal
     */
    protected function getHtmlFromLayout($layout, $params = [], $isTerminal = true) {
        $vm = new \Laminas\View\Model\ViewModel($params);
        $vm->setTerminal($isTerminal);
        $vm->setTemplate($layout);
        $html = $this->viewRenderer->render($vm);
        return $html;
    }

    /**
     * Create mail object only in need.
     * Configure mailer object according to module options configuration
     * @return \PHPMailer
     */
    protected function getMailer() {
        if ($this->mailer == NULL) {
            $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
            $smtpOptions = $this->options->getSmtpOptions();
            if ($this->options->getUseSmtp()) {
                $this->mailer->isSMTP();
                /* Enable SMTP debugging
                  0 = off (for production use)
                  1 = client messages
                  2 = client and server messages */
                $this->mailer->SMTPDebug = 0;
                /* Ask for HTML-friendly debug output */
                $this->mailer->Debugoutput = 'html';
                $this->mailer->SMTPSecure = 'ssl';
                /* Set the hostname of the mail server */
                $this->mailer->Host = $smtpOptions['smtp_host'];
                /* Set the SMTP port number - likely to be 25, 465 or 587 */
                $this->mailer->Port = $smtpOptions['smtp_port'];
                /* Whether to use SMTP authentication */
                $this->mailer->SMTPAuth = $smtpOptions['use_smtp_auth'];
                /* Username to use for SMTP authentication */
                $this->mailer->Username = $smtpOptions['smtp_username'];
                /* Password to use for SMTP authentication */
                $this->mailer->Password = $smtpOptions['smtp_password'];
            }
            $this->mailer->setFrom($this->options->getEmailFrom(), $this->options->getEmailFromName());
            $this->mailer->addReplyTo($this->options->getReplyTo());
        }
        return $this->mailer;
    }

    /**
     * 
     * @param int $length
     * @return string
     */
    public function getRandomString($length = 32) {
        $requestKey = Rand::getString($length, 'abcdefghijklmnopqrstuvwxyz'
                        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                        . '0123456789', true);
        return $requestKey;
    }

}
