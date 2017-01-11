<?php
class CsvFile implements IFile {

    private $_handler;
    private $_fieldsConfig;
    private $_delimiter;

    protected $fileName;

	public function __construct($fileName, CsvFieldsConfig $fieldsConfig, $delimiter) {
		$this->fileName = $fileName;
        $this->_fieldsConfig = $fieldsConfig;
        $this->_delimiter = $delimiter;
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

		while(($lineData = fgetcsv($this->_handler, 0, $this->_delimiter)) !== false) {
            $_tmp = [];

            foreach ($this->_fieldsConfig->getFields() as $key => $value) {
                $_tmp[$value] = isset($lineData[$key]) ? $lineData[$key] : '';
            }

            $data[] = $_tmp;
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
