<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 18.08.2019
 * Time: 9:30
 */

namespace Ilnurshax\Era\Support\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Jobby implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

}
