<?php

namespace Ilnurshax\Era\Support\Http;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueueController extends Controller
{

    public function __construct()
    {
        $this->middleware($this->accessMiddleware());
    }

    public function index()
    {
        return DB::connection($this->connectionName())
            ->table($this->tableName())
            ->get()
            ->map(function ($failedJob) {
                $failedJobData = [
                    'id'         => $failedJob->id,
                    'queue'      => $failedJob->queue,
                    'payload'    => $failedJob->payload,
                    'exception'  => $failedJob->exception,
                    'created_at' => Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $failedJob->failed_at)
                        ->toIso8601String(),
                ];

                if (!empty($failedJob->uuid)) {
                    $failedJobData['uuid'] = $failedJob->uuid;
                }

                return $failedJobData;
            });
    }

    public function retry()
    {
        if (empty($id = request()->input('id'))) {
            return $this->forInvalidId();
        }

        $exitCode = Artisan::call('queue:retry', ['id' => $id]);

        return response()->json(['success' => $exitCode === 0]);
    }

    public function delete()
    {
        if (empty($id = request()->input('id'))) {
            return $this->forInvalidId();
        }

        if ($id === 'all') {
            $exitCode = Artisan::call('queue:flush');
        } else {
            $exitCode = Artisan::call('queue:forget', ['id' => $id]);
        }

        return response()->json(['success' => $exitCode === 0]);
    }

    protected function connectionName()
    {
        return config('queue.failed.database');
    }

    protected function tableName()
    {
        return config('queue.failed.table');
    }

    protected function getQueueWebConsoleKey()
    {
        return env('QUEUE_WEB_CONSOLE_KEY');
    }

    protected function accessMiddleware()
    {
        return function ($request, $next) {
            if ($request->input('key') !== $this->getQueueWebConsoleKey()) {
                throw new NotFoundHttpException();
            }

            return $next($request);
        };
    }

    private function forInvalidId()
    {
        return response()->json(['message' => 'The job ID is required. Allowed: all, or any integer value'], 422);
    }

}
