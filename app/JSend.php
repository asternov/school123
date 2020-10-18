<?php

namespace App;

/**
 * Class JSend
 * Wrapper for JSend format response
 *
 * @see     https://github.com/omniti-labs/jsend
 * @package App
 */
class JSend {

	const STATUS_SUCCESS = 'success';
	const STATUS_FAIL    = 'fail';
	const STATUS_ERROR   = 'error';

	const ERROR_CODE_UNDEFINED = 0;
	const ERROR_CODE_APPLICATION = 1;
	const ERROR_CODE_AWS = 2;
	const ERROR_CODE_EMAIL_NOT_VERIFIED = 3;

	/**
	 * Return with Jsend array fail status and data
	 *
	 * @param null $data
	 * @return array
	 */
	public static function fail($data = null): array {
		return [
			'status' => static::STATUS_FAIL,
			'data'   => $data
		];
	}

	/**
	 * Return with Jsend array success status and data
	 *
	 * @param null $data
	 * @return array
	 */
	public static function success($data = null): array {
		return [
			'status' => static::STATUS_SUCCESS,
			'data'   => $data
		];
	}

	/**
	 * Return with Jsend array error status and data
	 *
	 * @param string|null $message
	 * @param int $error_code
	 * @return array
	 */
	public static function error(string $message = null, int $error_code = JSend::ERROR_CODE_UNDEFINED): array {
		return [
			'status'  => static::STATUS_ERROR,
			'message' => $message,
			'code' => $error_code
		];
	}

	/**
	 * Send JSON response with error message
	 * @param string|null $message
	 * @param int $error_code
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function errorResponse(string $message = null, int $error_code = JSend::ERROR_CODE_UNDEFINED){
		return response()->json(static::error($message, $error_code), 200,[],JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Send Success JSON response with data
	 * @param null $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function successResponse($data = null){
		return response()->json(static::success($data), 200,[],JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Send Fail JSON response with data
	 * @param null $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public static function failResponse($data = null){
		return response()->json(static::fail($data), 200,[],JSON_UNESCAPED_UNICODE);
	}


}