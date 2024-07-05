<?php
class Authenticator extends BaseAuthenticator
{
  public function handle($args) 
  {
    // Let the Authorizer check for the token
    if ($args["token"]) {
      // Decipher Token
      // Send Token deciphered to Authorizer
      return parent::handle($args);
    }

    if (!$this->emailExist($args["email"])) {
      echo "Error: Email not registered";
      return false;
    }

    if ($this->tooManyAttempts($args["email"])) {
      echo "Error: Too many attempts";
      return false;
    }

    // Check if pwd is valid
    if (!$this->pwdMatch($args["email"], $args["pwd"])) {
      echo "Error: Wrong password"; 
      return false;
    }

    return parent::handle($args);
  }
}
