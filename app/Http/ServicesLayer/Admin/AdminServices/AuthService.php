<?php

namespace App\Http\ServicesLayer\Admin\AdminServices;

use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function check_login($request)
    {
        try{
            $email = strtolower(trim((string) $request->email));
            $invalidLoginMessage = "Invalid email or password";

            $admin = $this->model->where('email', $email)->first();
            if($admin){

                if(FacadesHash::check($request->password, $admin->password)){

                    if($admin->is_activate == 1){

                        if(FacadesAuth::guard('admin')->attempt([
                            'email' => $email,
                            'password' => $request->password,
                        ])){

                            return redirect(route('admin/index'));
                        }else{
                            flash()->error($invalidLoginMessage);
                            return back();
                        }

                    }else{
                        flash()->error($invalidLoginMessage);
                        return back();
                    }

                }else{
                    flash()->error($invalidLoginMessage);
                    return back();
                }

            }else{
                flash()->error($invalidLoginMessage);
                return back();
            }
        }catch(\Exception $ex){
            Log::error('Admin login failed unexpectedly', [
                'email' => $request->email ?? null,
                'message' => $ex->getMessage(),
            ]);

            if ($ex instanceof QueryException || str_contains(strtolower($ex->getMessage()), 'sqlstate')) {
                flash()->error("Database connection failed. Please make sure MySQL is running.");
                return back();
            }

            flash()->error("There IS Something Wrong , Please Contact Technical Support");
            return back();
        }
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect(route('admin/login'));
    }
}
