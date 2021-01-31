<?php

namespace Src\Core;

class View
{
    private $template;
    private $data;

    public function __construct($template, $data = [])
    {
        $this->template = $template;
        $this->data = $data;

        $this->render($data);
    }

    private function render($data)
    {
        if (count($data)) {
            extract($data);
        }

        include(str_replace('\core', '', __DIR__) . '/view/' . $this->template);
    }
}