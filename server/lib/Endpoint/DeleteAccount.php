<?php
class DeleteAccount extends Service {

  const NEEDED_ARGS = ["email", "password"];

  function endpointMethod()
  {
    $filter = [
      "email" => [
        "operator" => "=",
        "value" => $this->email
      ]
    ];

    $this->db->delete("accounts", $filter);
  }
}

