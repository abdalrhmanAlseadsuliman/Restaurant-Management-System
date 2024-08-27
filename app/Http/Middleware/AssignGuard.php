<?php
namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Tymon\JWTAuth\Exceptions\TokenExpiredException;
// use Tymon\JWTAuth\Exceptions\JWTException;
// use App\Traits\GeneralTrait;
// use JWTAuth;


use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Response;

class AssignGuard
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard != null) {
            auth()->shouldUse($guard);  // تعيين الـ Guard المحدد

            $token = $request->header('auth-token');
            $request->headers->set('Authorization', 'Bearer ' . $token, true);

            try {
                $user = auth()->guard($guard)->user();
                // $user = JWTAuth::parseToken()->authenticate();
                if (!$user) {
                    return $this->returnError('1001', 'User not found');
                }
            } catch (TokenExpiredException $e) {
                return $this->returnError('1001', 'Token expired');
            } catch (JWTException $e) {
                return $this->returnError('1001', 'Token invalid');
            }
        }

        return $next($request);
    }
}
