<?php

namespace App\Http;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class Stub
{
    protected static $filename, $name, $namespace, $full_path;

    public static function of($filename, $name, $namespace, $full_path)
    {
        $filesystem = new Filesystem;

        self::$filename = $filename;
        self::$name = $name;
        self::$namespace = $namespace;
        self::$full_path = $full_path;

        // create file's folder
        $filesystem->ensureDirectoryExists(dirname(self::$full_path));

        // get file content
        $content = self::getSourceFile();

        // create file
        if($filesystem->exists(self::$full_path)) return "File Already Exists";

        $filesystem->put(self::$full_path, $content);

        return "File Created Successfully";
    }

    private static function getSourceFile()
    {
        $stub = __DIR__ . '/../../stubs/' . self::$filename;

        return self::getStubContent($stub, [
            'namespace' => self::$namespace,
            'class' => ucwords(Pluralizer::singular(self::$name)),
        ]);
    }

    private static function getStubContent($stub, $stub_vars)
    {
        $content  = file_get_contents($stub);

        foreach ($stub_vars as $name => $value)
        {
            $content = str_replace('{{ '.$name.' }}', $value, $content);
        }

        return $content;
    }
}
