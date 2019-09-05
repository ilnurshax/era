<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 23.11.2017
 * Time: 12:15
 */

namespace Ilnurshax\Era\Environment;

use Dotenv\Dotenv;
use Symfony\Component\Console\Input\ArgvInput;

class Environment
{

    /**
     * @var string
     */
    protected $path = '';
    /**
     * @var string
     */
    private $envFile;

    public function __construct($path, $envFile = 'local')
    {
        $this->path = $path;
        $this->envFile = $envFile;
    }

    public function configure($app)
    {
        if ($app->runningInConsole()) {
            $argvInput = new ArgvInput;
            $envFileName = $this->getEnvFilename($argvInput->getParameterOption('--env', 'local'));
        } else {
            $envFileName = $this->getEnvFilename(env('APPLICATION_ENV', 'local'));
        }

        try {
            Dotenv::create($this->path, $envFileName)->load();
        } catch (\Exception $exception) {
            //
        }
    }

    private function getEnvFilename($currentEnvironment = 'local')
    {
        return $currentEnvironment . '.env';
    }
}
