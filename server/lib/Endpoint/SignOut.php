<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SignOut extends Service {

  // Should not require the email
  const NEEDED_ARGS = ["token"];

  function endpointMethod()
  {
    $obj = SecuLib::getCredentials("token.json");
    $key = $obj["key"];
    $algo = $obj["algo"];

    $decodedToken = JWT::decode($this->token, new Key($key, $algo));

    $filter = [
      "id_account" => [
        "operator" => "=",
        "value" => $decodedToken->user_id
      ]
    ];

    $this->db->delete("tokens", $filter);
  }
}

