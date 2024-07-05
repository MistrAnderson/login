<?php

/**
 * Simple autoloader
 *
 * @param $class_name - String name for the class that is trying to be loaded.
 */
function my_custom_autoloader($className)
{
  // Define an array of directories to search for class files
  $directories = [
    __DIR__ . '/',
    __DIR__ . '/lib/Std/',
    __DIR__ . '/lib/Handlers/',
    __DIR__ . '/lib/Database/',
    __DIR__ . '/lib/Endpoint/',
  ];

  // Iterate through the directories
  foreach ($directories as $directory) {
    // Construct the file path
    $file = $directory . $className . '.php';
    // If the file exists, require it
    if (file_exists($file)) {
      require_once $file;
      return;
    }
  }
  // echo "Autoloader: {$className} not found";
}
// add a new autoloader by passing a callable into spl_autoload_register()
spl_autoload_register('my_custom_autoloader');

