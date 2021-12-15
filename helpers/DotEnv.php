<?php

namespace app\helpers;

class DotEnv
{
    protected $path;


    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            $this->path = false;
            // throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        } else {
            $this->path = $path;
        }
    }

    public function load(): void
    {
        if (!$this->path or !is_readable($this->path)) {
            return;
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
            }
        }
    }
}
