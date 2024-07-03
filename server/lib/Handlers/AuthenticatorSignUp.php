<?php
class AuthenticatorSignUp extends BaseAuthenticator
{
  public function handle($args): bool
  {
    if ($this->emailExist($args["email"])) {
      echo "Error: Email already exist";
      return false;
    }
    parent::handle($args);
  }
}
