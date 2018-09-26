<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserFormRequest;
use App\Http\Requests\User\UpdateUserIsActiveRequest;
use App\User;
use App\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'ok';
//        return Auth::user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data  = $request->all();

            if (isset($data['user_detail']) && isset($data['user_detail']['birthday'])) {
                $data['user_detail']['birthday'] = strtotime(Carbon::parse($data['user_detail']['birthday'])->format('Y-m-d'));
            }

            $updated = $this->user->find($id);
            $updated->update($data);

            if (isset($data['user_detail'])) {
                if (isset($updated->userDetail)) {
                    $updated->userDetail->update($data['user_detail']);
                } else {
                    if (!UserDetail::where('user_id', $id)) {
                        $data['user_detail']['user_id'] = $id;
                        UserDetail::create($data['user_detail']);
                    }
                }
            }

            DB::commit();
            return $this->api_success_response(['data' => $updated]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function detail(Request $request) {
        return $this->api_success_response(['data' => $this->user->detail($request->user())]);
    }

    public function changePassword(Request $request) {
        try {
            $current_password = Auth::User()->password;           
            if(Hash::check($request['current'], $current_password))
            {           
              $user_id = Auth::User()->id;                       
              $obj_user = User::find($user_id);
              $obj_user->password = Hash::make($request['new_pass']);;
              $obj_user->save(); 
              return $this->api_success_response(['data' => $obj_user]);
            }
        } catch(Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function profile()
    {
        $user_id = Auth::user()->id;
        try {
            $profile = $this->user->with(['userDetail'])->find($user_id);
            return $this->api_success_response(['data' => $profile]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function updateIsActive(UpdateUserIsActiveRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $updated = $this->user->find($id);
            $updated->update($request->all());

            DB::commit();
            return $this->api_success_response(['data' => $updated]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
