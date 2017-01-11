<?php


class CsvFieldsConfig {

    protected $fields = [];

    public function __construct($fields)
    {
        $this->setFields($fields);
    }

    public function getFields() {
        return $this->fields;
    }

    public function setFields(array $fields) {
        $this->fields = $fields;
    }
}