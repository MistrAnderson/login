<?php
abstract class BaseAuthenticator extends Handler
{
  protected $db;

  function __construct()
  {
    $this->db = new Database();
  }

  protected function emailExist(string $email)
  {
    $filter = [
      "email" => [
        "operator" => "=",
        "value" => $email
      ]
    ];

    $res = $this->db->read("accounts", "email", $filter);

    if ($res == "") {
      return false;
    }
    return true;
  }

  protected function pwdMatch(string $email, string $pwd)
  {
    $filter = [
      "email" => [
        "operator" => "=",
        "value" => $email
      ]
    ];
    
    $res = $this->db->read("accounts", "*", $filter);

    $jsonObj = json_decode($res);

    $hashedPwd = hash('sha512', $pwd.$jsonObj["salt"]);

    if ($hashedPwd == $jsonObj["pwd_hash"]) {
      return true;
    }

    return false;
  }

  protected function tooManyAttempts(string $email)
  {
    echo $email;
    return false;
  }
}
