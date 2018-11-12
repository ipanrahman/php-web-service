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
        $this->checkIfExistsContentType($this->contentType);
        http_response_code(200);
        echo json_encode($this->result(200, 'Success', $data));
        return $this;
    }

    private function checkIfExistsContentType($contentType)
    {
        if ($contentType == null) {
            $this->contentType("application/json");
        }
    }

    protected function contentType($contentType)
    {
        $this->contentType = $contentType;

        header('Content-type: ' . $contentType);
    }

    protected function result($code, $message, $data = null, $errors = null)
    {
        return array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        );
    }

    protected function badRequest($errors = null)
    {
        $this->checkIfExistsContentType($this->contentType);
        http_response_code(400);
        echo json_encode($this->result(400, 'Bad Request', null, $errors));
        return $this;
    }
}