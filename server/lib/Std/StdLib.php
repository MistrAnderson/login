<?php
class StdLib
{
  static function testNeededArgs($arrOfArgs, $classInstance)
  {
    foreach ($arrOfArgs as $arg) {
      if (!isset($classInstance->{$arg})) {
        echo json_encode(['error' => 'Missing ' . $arg . ' in JSON data']);
        return false;
      }
    }
    return true;
  }

  /**
 *
 * This function returns an associative array of a class attributes.
 *
 */
  static function genArgs(array $arrOfArgs, Service $classInstance): array
  {
    $args = array();
    foreach ($arrOfArgs as $arg) {
      $args[$arg] = $classInstance->{$arg};
    }

    return $args;
  }

  /**
   * function to get the name of the current directory
   *
   * @param string $currdir - full path of the current directory, for exemple "/dal/lib/dir"
   */
  static function className($currdir = "")
  {
    // refactor the string to match the class name
    $dirpath = str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']);
    $filepath = str_replace($currdir, "", $dirpath);

    return str_replace("/", "", $filepath);
  }
}

