<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/23/2018
 * Time: 2:25 AM
 */

namespace App\Http\Responses\Roles;


use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;

class RoleIndexResponse implements Responsable
{
    protected $roles;

    public function __construct(Collection $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(new ApiResponse('Get Roles Successful', $this->convertToDto(), 200));
        // TODO: Implement toResponse() method.
    }

    private function convertToDto(){
        return $this->roles->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'is_employee' => (bool) $item->is_employee
            ];
        });
    }
}