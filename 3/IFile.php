<?php

interface IFile {

    public function open($mode);
    public function close();
    public function read();
    public function write($data);
    public function getHandler();
}