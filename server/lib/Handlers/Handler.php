<?php
abstract class Handler {
  private $next;

  public function setNext(Handler $next) {
    $this->next = $next;
    return $next;
  }

  public function handle(...$args): bool {
    // If the handlers has no next handlers
    // it means the request went through all the CoR
    // therefore the request is valid
    
    if (!$this->next) {
      return true;
    }
    // Calls the handle function of the next Handles
    // in the CoR
    return $this->next->handle(...$args);
  }
}