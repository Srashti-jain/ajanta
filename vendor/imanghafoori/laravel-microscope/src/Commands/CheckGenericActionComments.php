<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Imanghafoori\LaravelMicroscope\Checks\ActionsUnDocblock;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;
use Imanghafoori\LaravelMicroscope\ForPsr4LoadedClasses;
use Imanghafoori\LaravelMicroscope\Traits\LogsErrors;

class CheckGenericActionComments extends Command
{
    use LogsErrors;

    protected $signature = 'check:docblocks';

    protected $description = 'Removes generic docblocks from controllers';

    public function handle(ErrorPrinter $errorPrinter)
    {
        $errorPrinter->printer = $this->output;

        $this->info('removing generic docblocks...');

        ActionsUnDocblock::$command = $this;

        ForPsr4LoadedClasses::check([ActionsUnDocblock::class]);

        $this->finishCommand($errorPrinter);

        return $errorPrinter->hasErrors() ? 1 : 0;
    }
}
