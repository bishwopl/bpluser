<?php

namespace BplUser\Provider;

interface UserServiceOptionsInterface extends
AuthenticationOptionsInterface, EmailOptionsInterface,
 ForgotPasswordOptionsInterface, ProfileOptionsInterface,
 RegistrationOptionsInterface {
    
}
