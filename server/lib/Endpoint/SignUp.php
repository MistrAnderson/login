<?php
class SignUp extends Service
{

  const NEEDED_ARGS = ["email", "password"];

  function endpointMethod()
  {
    $salt = bin2hex(random_bytes(16));
    $hashedPwd = hash('sha512', $this->password.$salt);

    $params = [
      "email" => $this->email,
      "pwd_hash" => $hashedPwd,
      "salt" => $salt,
    ];

    $this->db->create("accounts", $params);
  }

  static function genChainOfResponsibility(): Handler
  {
    $handler = new AuthenticatorSignUp();
    $authorizer = new Authorizer();

    $handler->setNext($authorizer);

    return $handler;
  }
}
