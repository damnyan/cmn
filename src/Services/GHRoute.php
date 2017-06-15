<?php

namespace Damnyan\Cmn\Services;

use Illuminate\Filesystem\Filesystem;

class GHRoute {

    static $module;

    public function __construct($module)
    {
        self::$module = $module;
        self::routeIt();
    }

    private static function routeIt()
    {
        $modulePath = module_path(self::$module);
        $routePath = module_path(self::$module, 'Routes');

        $files = \File::allFiles($routePath);

        foreach($files as $file)
        {
            $route = $file->getFilename();
            if(in_array($route, ['api.php', 'web.php']))
                continue;

            $filePath = $file->getPathname();
            
            $prefix = self::getPrefix($routePath, $filePath, $route);
            
            \Route::group([
                'prefix'     => $prefix,
            ], function ($router) use($filePath) {
                require $filePath;
            });
        }
    }

    private static function getPrefix($routePath, $filePath, $route)
    {
        $prefix = str_replace($routePath, '', $filePath);
        $prefix = str_replace("\\", "/", $prefix);
        if($route == 'index.php')
            return str_replace('index.php', '', $prefix);
        
        return str_replace('.php', '', $prefix);
    }
}