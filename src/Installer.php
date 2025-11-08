<?php 
namespace Axproo\CorsLib;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Installer
{
    public function install(Event|PackageEvent|null $event = null) : void {
        // Gestion de l'interface IO
        $io = null;
        if ($event instanceof Event || $event instanceof PackageEvent) {
            $io = $event->getIO();
        }

        if ($io) {
            $io->write("<info>Installing Axproo Cors Filter...</info>");
        } else {
            echo "Installing Axproo Cors Filter...\n";
        }

        // Détection des routes
        $rootDir = getcwd();
        $vendorDir = $rootDir . '/vendor/axproo/cors-lib/src/Filters';
        $destDir = $rootDir . '/app/Helpers';

        if (!is_dir($vendorDir)) {
            if ($io) {
                $io->write("<error>Source folder not found: {$vendorDir}</error>");
            } else {
                echo "Source folder not found: {$vendorDir}\n";
            }
        }

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        self::copyRecursive($vendorDir, $destDir);

        if ($io) {
            $io->write("<info>Filter Cors successfully installed in app/Filters.</info>");
        } else {
            echo "Filter Cors successfully installed in app/Filters.\n";
        }
    }

    private static function copyRecursive($src, $dest)
    {
        $dir = opendir($src);
        @mkdir($dest, 0755, true);

        while (($file = readdir($dir)) !== false) {
            if ($file == '.' || $file == '..') continue;

            $srcPath = "$src/$file";
            $destPath = "$dest/$file";

            if (is_dir($srcPath)) {
                self::copyRecursive($srcPath, $destPath);
            } else {
                copy($srcPath, $destPath);
            }
        }

        closedir($dir);
    }
}