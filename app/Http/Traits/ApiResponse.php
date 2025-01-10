<?php

namespace App\Http\Traits;

Trait ApiResponse {

    /**
     * General method for API response
     * @param mixed $data The data you want to send in the response.
     * @param string|null $message A message to send with the response.
     * @param int $code The HTTP status code.
     * @param bool $status The status of the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResponse($data = [], $message = null, $code = 200, $status = true)
    {
        return response()->json([
            'status' => $status,  // Indicates success or failure
            'message' => $message, // Optional message
            'data' => $data,       // The data to be sent in response
        ], $code);
    }

    /**
     * Return a success response with data.
     * @param mixed $data Data to return.
     * @param string|null $message Success message.
     * @param int $code HTTP status code (200 by default).
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data = [], $message = 'Operation successful', $code = 200)
    {
        return $this->apiResponse($data, $message, $code, true);
    }

    /**
     * Return an error response with message.
     * @param string|null $message Error message.
     * @param int $code HTTP status code (default is 400 or 404, depending on the error).
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = 'An error occurred', $code = 400)
    {
        return $this->apiResponse([], $message, $code, false);
    }

    /**
     * Return an unauthorized response (401).
     * @param string|null $message Custom message for unauthorized access.
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorizedResponse($message = 'Unauthorized access')
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a not found response (404).
     * @param string|null $message Message for not found error.
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundResponse($message = 'Resource not found')
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return a validation error response (422).
     * @param string|null $message Custom validation message.
     * @param array $errors Validation errors.
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationErrorResponse($message = 'Validation errors', $errors = [])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }

    /**
     * Return a response for a forbidden request (403).
     * @param string|null $message Custom message for forbidden error.
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbiddenResponse($message = 'Forbidden')
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a no content response (204).
     * @param string|null $message Optional message for no content.
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContentResponse($message = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], 204);
    }

}
