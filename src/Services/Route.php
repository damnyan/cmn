<?php

namespace Damnyan\Cmn\Services;

use Illuminate\Filesystem\Filesystem;

class Route
{

    protected static $module;

    /**
     * Constructor
     *
     * @param string $module Module name
     */
    public function __construct($module)
    {
        self::$module = $module;
        self::routeIt();
    }

    /**
     * Routing the module
     *
     * @return void
     */
    private static function routeIt()
    {
        $routePath = module_path(self::$module, 'Routes');

        $files = \File::allFiles($routePath);

        foreach ($files as $file) {
            $route = $file->getFilename();
            if (in_array($route, ['api.php', 'web.php'])) {
                continue;
            }

            $filePath = $file->getPathname();

            $prefix = self::getPrefix($routePath, $filePath, $route);

            \Route::group(
                [
                    'prefix' => $prefix,
                ],
                function ($router) use ($filePath) {
                    include $filePath;
                }
            );
        }
    }

    /**
     * Extract prefix from folders
     *
     * @param string $routePath Route Path
     * @param string $filePath  File path
     * @param string $route     Route
     * @return void
     */
    private static function getPrefix($routePath, $filePath, $route)
    {
        $prefix = str_replace($routePath, '', $filePath);
        $prefix = str_replace("\\", "/", $prefix);

        if ($route == 'index.php') {
            return str_replace('index.php', '', $prefix);
        }

        return str_replace('.php', '', $prefix);
    }
}
