<?php
class SignOut extends Service {

  // Should not require the email
  const NEEDED_ARGS = ["email", "token"];

  function endpointMethod()
  {
    $filter = [
      "email" => [
        "operator" => "=",
        "value" => $this->email
      ]
    ];

    $this->db->delete("tokens", $filter);
  }
}

