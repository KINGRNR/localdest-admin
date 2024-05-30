<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\DetailUser;
use App\Models\ManageUser;
use App\Models\Role;

class ListuserController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->post();
        if (isset($filter['date']) && isset($filter['role'])) {
            $dateRange = explode(' - ', $filter['date']);
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[0])->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[1])->endOfDay();

            $data = DB::table('users')->whereBetween('created_at', [$startDate, $endDate])->where('role', $filter['role'])
                ->get();
        } else if (isset($filter['role'])) {
            $data = DB::table('users')->where('role', $filter['role'])->get();
        } else if (isset($filter['date'])) {
            $dateRange = explode(' - ', $filter['date']);
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[0])->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[1])->endOfDay();

            $data = DB::table('users')->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        } else {
            $data = DB::table('users')->get();
        }
        return DataTables::of($data)->toJson();
    }

    public function showall(Request $request)
    {

        $data = ManageUser::leftJoin('detail_users', 'users.id', '=', 'detail_users.user_id')->get(['users.*', 'detail_users.*']);
        return response()->json();
    }

    public function show(Request $request)
    {
        $data = $request->post();
        $user_id = $data['id'];

        $userData = ManageUser::leftJoin('detail_users', 'users.id', '=', 'detail_users.user_id')
            ->where('users.id', $user_id)
            ->first();

        $userData['resume'] = DB::table('resume')->where('resume_user_id', $user_id)->first();
        if ($userData) {
            return response()->json([
                'status' => 'success',
                'data' => $userData,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }

    public function detailJob(Request $request)
    {
        $data = $request->post();
        $user_id = $data['id'];

        $userData = DB::table('v_users_job')
            ->where('job_users_users_id', $user_id)
            ->get();

        if ($userData->count() > 0) {
            $responseData = [
                'draw' => 1,
                'recordsTotal' => $userData->count(),
                'recordsFiltered' => $userData->count(),
                'data' => $userData
            ];

            return response()->json($responseData);
        } else {
            return response()->json(['message' => 'User belum punya pekerjaan', 'data' => []]);
        }
    }

    public function deleteUser(Request $request)
    {
        $data = $request->post('data');
        $callbackMessage = [];

        foreach ($data as $id => $value) {
            $user = DB::table('users')->where('id', $id)->first();

            if ($user) {
                DB::table('users')->where('id', $id)->update(['deleted_at' => now()]);
                $callbackMessage[$id] = 'User Dengan Id = ' . $id . ' Berhasil di Delete!.';
            } else {
                $callbackMessage[$id] = 'User Dengan Id ' . $id . ' Gagal di Delete!.';
            }
        }

        return response()->json([
            'message' => $callbackMessage,
            'status' => 'success',
        ]);
    }
}
