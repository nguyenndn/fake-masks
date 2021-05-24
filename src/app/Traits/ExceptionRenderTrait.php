<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Workflow\Exception\NotEnabledTransitionException;
use Symfony\Component\Workflow\Exception\UndefinedTransitionException;
use Throwable;

trait ExceptionRenderTrait
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e)
    {
        $data = [
            'status' => $e instanceof HttpException ? $e->getStatusCode() : config('constants.HTTP_STATUS_CODE.SERVER_ERROR'),
            'errors' => [[
                'title' => trans('messages.common.serverError'),
                'detail' => $e->getMessage() ?: ('An exception of ' . get_class($e)),
            ]],
        ];

        if ($e instanceof UnauthorizedException || $e instanceof AuthenticationException) {
            $data = array_merge($data, [
                'status' => config('constants.HTTP_STATUS_CODE.UNAUTHORIZED'),
                'errors' => [[
                    'title' => trans('messages.common.unauthorized'),
                    'detail' => $e->getMessage() ?: trans('messages.common.unauthorized'),
                ]],
            ]);
        }

        if ($e instanceof ModelNotFoundException) {
            $data = array_merge($data, [
                'status' => config('constants.HTTP_STATUS_CODE.NOT_FOUND'),
                'errors' => [[
                    'title' => trans('messages.common.notFoundError'),
                    'detail' => trans('messages.common.notFoundModel'),
                ]],
            ]);
        }

        if ($e instanceof HttpException) {
            $data = array_merge($data, [
                'status' => $e->getStatusCode(),
                'errors' => [[
                    'title' => trans('messages.common.notFoundError'),
                    'detail' => $e->getMessage() ?: ('An exception of ' . get_class($e)),
                ]],
            ]);
        }

        if ($e instanceof HttpResponseException) {
            $data = array_merge($data, [
                'status' => $e->getResponse()->getStatusCode(),
            ]);

            $errorResponses = function ($errors) use ($data) {
                foreach ($errors as $key => $error) {
                    if (!is_array($error)) {
                        $errorResponses[] = [
                            'title' => trans('messages.common.badRequest'),
                            'detail' => $error,
                        ];
                    } else {
                        foreach ($error as $detail) {
                            $errorResponses[] = [
                                'title' => $data['title'],
                                'detail' => $detail,
                                'source' => [
                                    'param' => $key,
                                ],
                            ];
                        }
                    }
                }
                return $errorResponses;
            };
            $data['errors'] = $errorResponses((array) $e->getResponse()->getContent());
        }

        if ($e instanceof ValidationException) {
            $data = array_merge($data, [
                'status' => config('constants.HTTP_STATUS_CODE.BAD_REQUEST'),
            ]);

            $errorResponses = function ($errors) use ($data) {
                foreach ($errors as $key => $error) {
                    if (!is_array($error)) {
                        $errorResponses[] = [
                            'detail' => $error,
                        ];
                    } else {
                        foreach ($error as $detail) {
                            $errorResponses[] = [
                                'detail' => $detail,
                                'source' => [
                                    'param' => $key,
                                ],
                            ];
                        }
                    }
                }
                return $errorResponses;
            };
            $data['errors'] = $errorResponses($e->validator->errors()->toArray());
        }

        return response()->json($data, $data['status']);
    }
}
