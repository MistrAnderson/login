<?php
abstract class Service
{

  const ALLOWED_ARGS = ["email", "password", "newPassword", "token"];
  const NEEDED_ARGS = [];

  function __construct()
  {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
      http_response_code(405);
      echo json_encode(['error' => 'Method Not Allowed']);
      return;
    }

    $jsonData = json_decode(file_get_contents('php://input'), true);

    if ($jsonData == null) {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid JSON data']);
      return;
    }

    // Sets json data as class attributes
    foreach ($jsonData as $attribute => $value) {
      if (in_array($attribute, self::ALLOWED_ARGS)) {
        $this->{$attribute} = $value;
      }
    }

    // Only calls Trig if JSON data was sent
    static::Trig();
  }

  private function Trig()
  {
    if (!StdLib::testNeededArgs(self::NEEDED_ARGS, $this)) {
      return;
    }

    $cor = $this->genChainOfResponsibility();

    $args = StdLib::genArgs(self::NEEDED_ARGS, $this);

    if ($cor->handle($args)) {
      $this->endpointMethod();
    }
  }

  abstract function endpointMethod();

  function genChainOfResponsibility(): Handler
  {
    $handler = new Authenticator();
    $handler->setNext(new Authorizer());

    return $handler;
  }
}
