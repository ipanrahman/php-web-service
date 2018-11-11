<?php

class Controller extends Model
{
    protected function model($file)
    {
        require PATH . "models/" . $file . ".php";

        $this->{$file} = new $file;

        return $this;
    }
}