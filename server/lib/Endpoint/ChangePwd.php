<?php
class ChangePwd extends Service {

  const NEEDED_ARGS = ["email", "password", "newPassword"];

  function endpointMethod()
  {
    // ChangePwd logic
    // Database call...

    $salt = bin2hex(random_bytes(16));
    $pwdHash = hash('sha512', $this->password.$salt);

    $params = [
      "pwd_hash" => $pwdHash,
      "salt" => $salt
    ];

    $filter = [
      "email" => [
        "operator" => "=",
        "value" => $this->email
      ]
    ];

    $this->db->update("accounts", $params, $filter);
  }
}
