<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ConfinementRequest;

class ConfinementsController extends Controller
{
    public function store(User $user, ConfinementRequest $request)
    {
        if ($user->hasPermissionTo('manage users')) {
            return redirect()->back()->with('danger', '不可禁言该用户');
        }

        $expired_at = $request->expired_in_days ? now()->addDays($request->expired_in_days) : null;

        $user->confine($request->is_permanent, $expired_at);

        return redirect()->back()->with('success', '已禁言该用户');
    }


    public function destroy(User $user)
    {
        $user->release();

        return redirect()->back()->with('success', '已取消禁言');
    }
}
