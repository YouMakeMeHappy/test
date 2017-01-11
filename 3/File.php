<?php
class File implements IFile {

    private $_handler;

    protected $fileName;

	public function __construct($fileName) {
		$this->fileName = $fileName;
	}

    public function open($mode = "r")
    {
        if (!file_exists($this->fileName)) {
            throw new Exception($this->fileName . ' not exists');
        }

        $this->_handler = fopen($this->fileName, $mode);
        $this->_checkIsFileOpen();
        return $this;
    }

	public function read() {
        $this->_checkIsFileOpen();

        $data = [];

		while(($line = fgets($this->_handler)) !== false) {
            $data[] = trim($line);
		}

        return $data;
	}

	public function	write($data) {
        $this->_checkIsFileOpen();
        return fwrite($this->_handler, $data);
    }

    public function close()
    {
        fclose($this->_handler);
    }

    public function getMutex()
    {
        return new FileMutex($this);
    }

    public function getHandler()
    {
        return $this->_handler;
    }

    private function _checkIsFileOpen()
    {
        if(empty($this->_handler)) {
            throw new Exception ($this->fileName . ' was not opened');
        }
    }
}
