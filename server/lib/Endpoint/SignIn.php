<?php
class SignIn extends Service {

  const NEEDED_ARGS = ["email", "password"];

  function endpointMethod()
  {
    // Should be signed in thanks to 
    // the Authorizer
    echo "you're signed in !";
  }
}
