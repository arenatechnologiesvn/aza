<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Permission;

class PermissionController extends Controller
{
    //
    public function create(CreatePermissionRequest $request){
        $data = $request->all();
        return Permission::create([
            'name' => $data['name'],
            'title' => $data['title'],
            'url_action' => $data['url_action']
        ]);
    }
}
