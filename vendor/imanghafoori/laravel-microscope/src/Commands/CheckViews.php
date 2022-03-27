<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Imanghafoori\LaravelMicroscope\Analyzers\ComposerJson;
use Imanghafoori\LaravelMicroscope\BladeFiles;
use Imanghafoori\LaravelMicroscope\Checks\CheckViewFilesExistence;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;
use Imanghafoori\LaravelMicroscope\ErrorTypes\BladeFile;
use Imanghafoori\LaravelMicroscope\LaravelPaths\FilePath;
use Imanghafoori\LaravelMicroscope\SpyClasses\RoutePaths;
use Imanghafoori\TokenAnalyzer\FunctionCall;

class CheckViews extends Command
{
    public static $checkedCallsNum = 0;

    public static $skippedCallsNum = 0;

    protected $signature = 'check:views {--d|detailed : Show files being checked}';

    protected $description = 'Checks the validity of blade files';

    public function handle(ErrorPrinter $errorPrinter)
    {
        event('microscope.start.command');
        $this->info('Checking views...');
        $errorPrinter->printer = $this->output;
        $this->checkRoutePaths();
        $this->checkPsr4Classes();
        $this->checkBladeFiles();

        $this->getOutput()->writeln(' - '.self::$checkedCallsNum.' view references were checked to exist. ('.self::$skippedCallsNum.' skipped)');
        event('microscope.finished.checks', [$this]);

        return $errorPrinter->hasErrors() ? 1 : 0;
    }

    private function checkForViewMake($absPath, $staticCalls)
    {
        $tokens = \token_get_all(\file_get_contents($absPath));

        foreach ($tokens as $i => $token) {
            if (FunctionCall::isGlobalCall('view', $tokens, $i)) {
                $this->checkViewParams($absPath, $tokens, $i, 0);
                continue;
            }

            foreach ($staticCalls as $class => $method) {
                if (FunctionCall::isStaticCall($method[0], $tokens, $i, $class)) {
                    $this->checkViewParams($absPath, $tokens, $i, $method[1]);
                    continue;
                }
            }
        }
    }

    private function checkViewParams($absPath, &$tokens, $i, $index)
    {
        $params = FunctionCall::readParameters($tokens, $i);

        $param1 = null;
        // it should be a hard-coded string which is not concatinated like this: 'hi'. $there
        $paramTokens = $params[$index] ?? ['_', '_', '_'];

        if (FunctionCall::isSolidString($paramTokens)) {
            self::$checkedCallsNum++;
            $viewName = \trim($paramTokens[0][1], '\'\"');

            $viewName && ! View::exists($viewName) && BladeFile::isMissing($absPath, $paramTokens[0][2], $viewName);
        } else {
            self::$skippedCallsNum++;
        }
    }

    private function checkRoutePaths()
    {
        foreach (RoutePaths::get() as $filePath) {
            $this->checkForViewMake($filePath, [
                'View' => ['make', 0],
                'Route' => ['view', 1],
            ]);
        }
    }

    private function checkPsr4Classes()
    {
        $psr4Mapping = ComposerJson::readAutoload();

        foreach ($psr4Mapping as $_namespace => $dirPath) {
            foreach (FilePath::getAllPhpFiles($dirPath) as $filePath) {
                $this->checkForViewMake($filePath->getRealPath(), [
                    'View' => ['make', 0],
                ]);
            }
        }
    }

    private function checkBladeFiles()
    {
        BladeFiles::check([CheckViewFilesExistence::class]);
    }
}
