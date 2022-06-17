<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */


$PHPUNIT = __DIR__ . '/../vendor/zf1s/phpunit/composer/bin/phpunit';
if (!is_executable($PHPUNIT)) {
    echo "PHPUnit is not executable ($PHPUNIT)";
    exit;
}

// locate all tests
$files = glob('{Zend/*/AllTests.php,Zend/*Test.php}', GLOB_BRACE);
sort($files);

// we'll capture the result of each phpunit execution in this value, so we'll know if something broke
$result = 0;
$failedFiles = [];

// run through phpunit
foreach ($files as $file) {
    echo "Executing {$file}" . PHP_EOL;
    system($PHPUNIT . ' --stderr -d memory_limit=-1 -d error_reporting=E_ALL\&E_STRICT -d display_errors=1 ' . escapeshellarg($file), $c_result);
    echo PHP_EOL;
    echo "Finished executing {$file}" . PHP_EOL;

    if ($c_result) {
        echo PHP_EOL . "Result of $file is $c_result" . PHP_EOL . PHP_EOL;
        $result = $c_result;
        $failedFiles[] = $file;
    }
}


echo PHP_EOL . "All done. Result: $result" . PHP_EOL;

if ($result) {
    sort($failedFiles);
    echo PHP_EOL . count($failedFiles) . ' test files failed: ' . PHP_EOL . PHP_EOL;
    echo implode(PHP_EOL, $failedFiles) . PHP_EOL . PHP_EOL;
}

exit($result);
