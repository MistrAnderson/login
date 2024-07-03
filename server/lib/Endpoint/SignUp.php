<?php
class SignUp extends Service
{

  const NEEDED_ARGS = ["email", "password"];

  function endpointMethod()
  {
    // SignUp logic
    // Database call...
  }

  function genChainOfResponsibility(): Handler
  {
    $handler = new AuthenticatorSignUp();
    $handler->setNext(new Authorizer());

    return $handler;
  }
}
