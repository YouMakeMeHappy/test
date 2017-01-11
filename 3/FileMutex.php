<?php

class FileMutex {

    private $_file;

    public function __construct(IFile $file)
    {
        $this->_file = $file;
    }

    public function lock()
    {
        return flock($this->_file->getHandler(), LOCK_EX);
    }

    public function unlock()
    {
        return flock($this->_file->getHandler(), LOCK_UN);
    }

    public function isLock()
    {
        return !$this->lock();
    }
}