<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
 
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // This will replace our 404 response with
        // a JSON response.
        if ($e instanceof ModelNotFoundException or
            $e instanceof NotFoundHttpException)
        {
            return response()->json([
                'data' => 'Our monkeys could not find your request'
            ], 404);
        } elseif ($e instanceof BadRequestHttpException) {
            return response()->json([
                'data' => 'Our monkeys are kicking around so something went wrong'
            ], 400);
        } elseif ($e instanceof UnauthorizedHttpException) {
            return response()->json([
                'data' => 'Our monkeys wont let you through get them a banana'
            ], 403);
        } elseif ($e instanceof AuthenticationException) {
            return response()->json([
                'data' => 'The monkeys told me your not allowed so'
            ], 401);
        } elseif ($e instanceof InternalErrorException) {
            return response()->json([
                'data' => 'The monkeys broke something please return'
            ], 500);
        } elseif ($e instanceof  ServiceUnavailableHttpException) {
            return response()->json([
                'data' => 'The monkeys has gone missing'
            ], 503);
        }
 
        return parent::render($request, $e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */

   /*
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
    */

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
