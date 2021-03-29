<?php

namespace Cms\Modules\Core\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cms\Modules\Core\Requests\UserCreateRequest;
use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $user;

    public function __construct(UserServiceContract $user)
    {
        $this->user = $user;
    }

    public function showRegistrationForm()
    {
        return view('Core::auth.register');
    }

    public function register(UserCreateRequest $request)
    {
        $user = $this->user->store($request->all());
        event(new Registered($user));
        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
