<?php
class Authenticator extends Handler
{
  public function handle(...$args): bool
  {
    // Let the Authorizer check for the token
    if ($token) {
      // Uncipher Token
      return parent::handle(...$args);
    }

    if ($req["errorIfExist"] && $this->emailExist($req["email"])) {
      echo "error: Email already in use";
      return false;
    }

    if (!$this->emailExist($req["email"])) {
      echo "error: Email not registered";
      return false;
    }
    return parent::handle($req);
  }

  private static function emailExist(string $email)
  {
  }

  private static function checkCredentials(string $email, string $pwd)
  {
  }
}
