<?php


namespace Ilnurshax\Era\Support\Shell;


class ShellCommand
{

    /**
     * @var \Closure|null
     */
    protected $before;
    /**
     * @var \Closure|null
     */
    protected $after;

    public function before(\Closure $before)
    {
        $this->before = $before;

        return $this;
    }

    public function after(\Closure $after)
    {
        $this->after = $after;

        return $this;
    }

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
        if ($this->before instanceof \Closure) {
            callIfCallable($this->before);
        }

        if ($this->runningOnWindows()) {
            return null;
        }

        $result = shell_exec($command);

        if ($this->after instanceof \Closure) {
            callIfCallable($this->after);
        }

        return $result;
    }
}
