<?php
abstract class Service
{

  const ALLOWED_ARGS = ["email", "password", "newPassword", "token"];
  const NEEDED_ARGS = [];
  protected $db;  

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

    $this->db = new Database();

    // Only calls Trig if JSON data was sent
    static::Trig();
  }

  private function Trig()
  {
    if (!StdLib::testNeededArgs(self::NEEDED_ARGS, $this)) {
      echo "Not enough arguments";
      return;
    }

    $cor = static::genChainOfResponsibility();

    $args = StdLib::genArgs(self::NEEDED_ARGS, $this);

    if ($cor->handle($args)) {
      $this->endpointMethod();
    }
  }

  static function genChainOfResponsibility(): Handler
  {
    $handler = new Authenticator();
    $authorizer = new Authorizer();

    $handler->setNext($authorizer);

    return $handler;
  }

  abstract function endpointMethod();
}
