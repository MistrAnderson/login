<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authorizer extends Handler
{
  public function handle($args): bool
  {
    if ( ! $args["token"]) {
      $token = $this->genToken($args["email"]);
      $this->tokenToDB($args["email"], $args["token"]);

      echo "Here's your token: \n";
      echo $token."\n";

      return parent::handle($args);
    }

    if ($this->tokenIsValid($args["token"])) {
      return parent::handle($args);
    }

    return false;
  }


  function genToken($email)
  {
    $filter = [ "email" => $email ];

    $user_id = $this->db->read("accounts", "id_account", $filter);

    $payload = [ "user_id" => $user_id ];

    $obj = SecuLib::getCredentials("token.json");

    return JWT::encode($payload, $obj["key"], $obj["algo"]);
  }

  function tokenIsValid($token): bool
  {
    $obj = SecuLib::getCredentials("token.json");
    $key = $obj["key"];
    $algo = $obj["algo"];

    try {
      $decodedToken = JWT::decode($token, new Key($key, $algo));
    } catch (Exception $e) {
      echo $e;
      return false;
    }

    if ($decodedToken == "") {
      return false;
    }

    return true;
  }

  function tokenToDB($token)
  {
    $obj = SecuLib::getCredentials("token.json");
    $key = $obj["key"];
    $algo = $obj["algo"];

    $decodedToken = JWT::decode($token, new Key($key, $algo));

    $params = [
      "user_id" => $decodedToken->user_id,
      "token" => $token
    ];

    $this->db->create("tokens", $params);
  }
}
