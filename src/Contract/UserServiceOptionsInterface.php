<?php

namespace BplUser\Contract;

interface UserServiceOptionsInterface extends
AuthenticationOptionsInterface, EmailOptionsInterface,
 ForgotPasswordOptionsInterface, ProfileOptionsInterface,
 RegistrationOptionsInterface {
    
}
