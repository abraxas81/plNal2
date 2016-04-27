<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\PorukeOperaterima;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		switch($e){
			/*case ($e instanceof NotFoundHttpException):
				Flash::error('Ova stranica ne postoji');
				return back();
				break;*/
			case ($e instanceof ModelNotFoundException):
				Flash::error('Model nije pronađen');
				redirect("home");
				break;
			case ($e instanceof TokenMismatchException):
				Flash::error('Tokeni se razlikuju ili je vaša sesija istekla');
				return back();
				break;
			case ($e instanceof QueryException):
				Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
				return back();
				break;
		}
		return parent::render($request, $e);
	}
}