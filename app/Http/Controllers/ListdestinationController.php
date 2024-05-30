<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

use App\Models\DetailUser;
use App\Models\ManageUser;
use App\Models\Role;

class ListdestinationController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->post();
        if (isset($filter['date'])) {
            $dateRange = explode(' - ', $filter['date']);
            $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[0])->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', $dateRange[1])->endOfDay();

            $data = DB::table('v_detail_destination')->whereBetween('destination_created_at', [$startDate, $endDate])
                ->get();
        } else {
            $data = DB::table('v_detail_destination')->get();
        }
        return DataTables::of($data)->toJson();
    }
}
