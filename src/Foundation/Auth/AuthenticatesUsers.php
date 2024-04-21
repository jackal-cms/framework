<?php

namespace Quagga\Quagga\Foundation\Auth;

use Quagga\Quagga\Exceptions\Validation\ValidationException;
use Slim\Psr7\Request;
use Valitron\Validator;

trait AuthenticatesUsers
{
    use RedirectsUsers;
    use ThrottlesLogins;

    protected function validateLogin(Request $request)
    {
        $params = $request->getQueryParams();
        $v = new Validator($params);
        $v->rule('required', [$this->username(), 'passwd']);

        if ($v->validate()) {
            return true;
        }
        throw new ValidationException();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);


        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            // $this->credentials($request), $request->filled('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => 'login_fail',
        ]);
    }
}
