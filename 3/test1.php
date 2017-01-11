<?php
require_once 'IFile.php';
require_once 'FileMutex.php';
require_once 'File.php';
require_once 'Math.php';


$file = new File('test.txt');

$file->open();

while(true) {
    if (!$file->getMutex()->isLock()) {
        $data = $file->open("a+")->read();
        $file->getMutex()->lock();
        //sleep(10);
        $data = Math::calculateNumbers($data);
        $file->write(PHP_EOL . $data);
        $file->getMutex()->unlock();
        $file->close();
        break;
    }
}
