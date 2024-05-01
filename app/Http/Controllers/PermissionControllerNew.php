<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Permission;
class PermissionControllerNew extends Controller
{
    public function __construct()
    {
        Gate::define('browse_ticket', function ($user) {
            return $user->hasPermission('browse_ticket');
        });
    }

    public function index()
    {
        info(auth()->user()->permissions);
        $this->authorize('browse_ticket');

        Permission::updateOrCreate(
            ['key' => 'browse_ticket'],
            ['table_name' => null]
        );

        // Additional logic if needed...

        return response()->json(['message' => 'Permission created or updated successfully']);
    }

    protected function guard()
    {
        return Auth::guard(app('VoyagerGuard'));
    }
}
