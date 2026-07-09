<?php

namespace App;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Get the path to the bootstrap cache directory.
     *
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->basePath(DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}
