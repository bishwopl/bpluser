# bpluser
An user registration, authentication and authorization module for Laminas-MVC based on [bishwopl/zf3-circlical-user](https://github.com/bishwopl/zf3-circlical-user/)

# Features
* User Registration
* Forgot password feature
* View helpers
* Laminas Developers Toolbar extention

# Requirements
Check [composer.json](https://github.com/bishwopl/bpluser/blob/master/composer.json) file for requirements.
    
# Installation
* Run following from project root directory 
```bash
    $ composer require bishwopl/bpluser
```
* Enable module in application.config.php
```php
<?php
return [
    'modules' => [
        // ...
        'CirclicalUser',
        'BplUser',
    ],
    // ...
];
```
* Follow configuration step
* Create database using following command 
```bash
    ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:create
```
# Configuration

### bishwopl/bpluser & bishwopl/zf3-circlical-user
Copy [config/bpluser.local.php.dist](https://github.com/bishwopl/bpluser/blob/master/config/bpluser.local.php.dist) file to your configuration folder and remove .dist from its name. Module configuration required for [bishwopl/zf3-circlical-user](https://github.com/bishwopl/zf3-circlical-user/) is also included in this config file so separate configuration for [bishwopl/zf3-circlical-user](https://github.com/bishwopl/zf3-circlical-user/) is not necessary.

# Options

# Controller plugins
* Change Password
```php
    $this->bpluser()->changePassword(UserInterface $user, $newPassword);
```
* Change Email
```php
    $this->bpluser()->changeEmail(UserInterface $user, $newEmail);
```
* Is Email in use
```php
    $this->bpluser()->isEmailInUse($email);
```
* Verify password
```php
    $this->bpluser()->verifyPassword(UserInterface $user, $password);
```
* Save Profile
```php
    $this->bpluser()->saveProfile(UserInterface $user);
```
* Can access action
```php
    $this->bpluser()->isAllowedAction($controllerName, $action);
```
# To do 
* Add Remember Me feature
