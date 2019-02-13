<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }
        if ($exception instanceof HttpException) {
            if ($exception->getStatusCode() == 403) {
                if ($request->getMethod() == 'POST') {
                    return response()->json([
                        'code' => 10000,
                        'data' => '您没有操作权限！请联系管理员！',
                    ]);
                } elseif ($request->getMethod() == 'GET') {
                    return response()->view('error', [
                        'httpStatus' => $exception->getStatusCode(),
                        'data' => '您没有操作权限！请联系管理员！']);
                }
            }
        }
        return response()->view('error', [
            'httpStatus' => '500',
            'data' => '这仅是一个小问题，不用担心！']);
//        return parent::render($request, $exception);
    }
}
