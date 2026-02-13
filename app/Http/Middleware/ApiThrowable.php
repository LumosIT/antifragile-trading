<?php

namespace App\Http\Middleware;

use App\Exceptions\Admins\DontHavePermissionsException;
use App\Utilits\Api\ApiError;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiThrowable
{

    protected function validationExceptionToApiError(ValidationException $e) : ApiError
    {

        if(config('app.debug')) {

            $msg = '';

            $errors = $e->errors();

            foreach($errors as $field => $messages) {
                $msg .= $field . ": " . $messages[0] . " | ";
            }

            throw new ApiError($msg, 422);

        }else{

            $errors = $e->errors();
            $errors = array_pop($errors);
            $error = $errors[0];

            throw new ApiError($error, 422);

        }

    }

    protected function throwableToApiError(\Throwable $e) : ApiError
    {

        if(config('app.debug')){
            throw new ApiError($e->getFile() . ':' . $e->getLine() . ':' . $e->getMessage(), 500);
        }else{
            throw new ApiError('System error', 500);
        }

    }

    protected function redirectToApiError(HttpException $e) : ApiError
    {
        return new ApiError($e->getMessage(), $e->getStatusCode());
    }

    protected function modelNotFoundToApiError(ModelNotFoundException $e) : ApiError
    {
        return new ApiError('Not Found', 404);
    }

    protected function authExceptionToApiError(AuthenticationException $e) : ApiError
    {
        return new ApiError('Need auth', 403);
    }

    protected function permissionsExceptionToApiError(DontHavePermissionsException $e) : ApiError
    {
        return new ApiError('Dont have permissions to do that', 403);
    }

    public function handle(Request $request, Closure $next)
    {

      try {

          try {

              $response = $next($request);

              if ($response->exception) {
                  throw $response->exception;
              }


              if ($response instanceof JsonResponse) {
                  $content = $response->getData(true);
              } else {
                  $content = $response->getContent();
              }

              return response()->json([
                  'status' => true,
                  'response' => $content
              ]);


          }catch (DontHavePermissionsException $e){
              throw $this->permissionsExceptionToApiError($e);
          }catch (AuthenticationException $e) {
              throw $this->authExceptionToApiError($e);
          }catch (ModelNotFoundException $e){
              throw $this->modelNotFoundToApiError($e);
          }catch (HttpException $e) {
              throw $this->redirectToApiError($e);
          } catch (ValidationException $e){
              throw $this->validationExceptionToApiError($e);
          } catch (ApiError $e){
              throw $e;
          } catch (\Throwable $e) {
              throw $this->throwableToApiError($e);
          }

      }catch (ApiError $e){

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

      }catch (\Throwable $e){

          return response()->json([
              'status' => false,
              'error' => 'Server error!',
              'code' => 500
          ]);

      }

    }



}
