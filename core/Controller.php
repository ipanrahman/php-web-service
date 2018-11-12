<?php

class Controller extends Model
{
    private $contentType;

    protected function model($file)
    {
        require PATH . "models/" . $file . ".php";

        $this->{$file} = new $file;

        return $this;
    }

    protected function ok($data)
    {
        if ($this->contentType == null) {
            header('Content-type: application/json');
        }
        $result = [
            'code' => 200,
            'message' => 'success',
            'data' => $data,
            'errors' => null
        ];
        echo json_encode($result);
        return $this;
    }

    protected function contentType($contentType)
    {
        $this->contentType = $contentType;

        header('Content-type: ' . $contentType);
    }
}