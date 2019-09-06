<?php


namespace Ilnurshax\Era\Support\Shell;


class ShellCommand
{

    /**
     * Determine is the PHP running on Windows or not
     *
     * @return bool
     */
    protected function runningOnWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Execute the given command through shell
     *
     * @param string $command
     * @return string
     */
    protected function execute(string $command): ?string
    {
        if ($this->runningOnWindows()) {
            return null;
        }

        return shell_exec($command);
    }
}
