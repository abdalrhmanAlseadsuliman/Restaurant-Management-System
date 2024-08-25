<?php

namespace App\Http\Controllers\Admin;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AdminController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
{
    // إعداد حقول التحقق
    $required_field = [
        'name'     => 'required|string|max:50|min:3',
        'email'    => 'required|string|email|max:100',
        'password' => 'required|string|max:100',
    ];

    // التحقق من المدخلات باستخدام Validator
    $validator = Validator::make($request->all(), $required_field);

    // التحقق إذا كانت البيانات غير صحيحة
    if ($validator->fails()) {
        // إذا كان هناك أخطاء، قم بإرجاع مصفوفة الأخطاء
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code,$validator);
    }

    // المصادقة باستخدام JWT
    $credentials = $request->only('email', 'password');
    $token = auth()->guard('admin-api')->attempt($credentials);
    // (!$token = JWTAuth::attempt($credentials))
    if (!$token) {
        return $this->returnError('E001','Unauthorized');
        // return response()->json(['error' => 'Unauthorized'], 401);
    }
    $admin = auth()->guard('admin-api')->user();
    $admin -> token_api = $token;
    return $this->returnData('admin',$admin,'تم بنجاح');
    // return $this->respondWithToken($token);
}


}
