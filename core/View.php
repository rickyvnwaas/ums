<?php

namespace core;


use config\Constants;
use function Couchbase\defaultDecoder;
use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $viewName;

    /**
     * @var array
     */
    private $data = [];

    /**
     * View constructor.
     * @param $viewName
     * @return $this
     */
    public function __construct($viewName)
    {
        $this->setPath($_SERVER['DOCUMENT_ROOT'] . '/' . Constants::APP_SUB_DIR . '/' . Constants::VIEW_PATH . '/');
        $this->setViewName($viewName);
    }

    /**
     * @return string
     */
    private function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    private function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * @param string $viewName
     */
    public function setViewName($viewName)
    {
        $this->viewName = $viewName;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $loader = new Twig_Loader_Filesystem($this->getPath());
        $twig = new Twig_Environment($loader);

        $defaultData = [
            'root' => Constants::APP_FULL_URL,
            'isAdmin' => Auth::isAdmin(),
            'errors' => Validator::getErrors()
        ];

        return $twig->render($this->getViewName(), array_merge($defaultData, $this->getData()));
    }
}