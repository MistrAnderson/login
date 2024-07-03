<?php
abstract class BaseAuthenticator extends Handler
{

  protected static function emailExist(string $email)
  {
  }

  protected static function checkCredentials(string $email, string $pwd)
  {
  }

  protected static function tooManyAttempts(string $email)
  {
  }
}
