<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Login;
use App\Models\Unit;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalLogins = Login::count();
        $totalUnits = Unit::count();
        $totalJabatans = Jabatan::count();

        $topEmployees = DB::table('logins')
            ->join('employees', 'logins.employee_id', '=', 'employees.id')
            ->select('employees.name', 'logins.employee_id', DB::raw('COUNT(*) as login_count'), 
                    DB::raw('MIN(logins.created_at) as first_login_date'), 
                    DB::raw('MAX(logins.created_at) as last_login_date'))
            ->groupBy('logins.employee_id', 'employees.name')
            ->havingRaw('COUNT(*) > 25')
            ->orderByDesc('login_count')
            ->limit(10)
            ->get();

        return Inertia::render('Dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalLogins' => $totalLogins,
            'totalUnits' => $totalUnits,
            'totalJabatans' => $totalJabatans,
            'topEmployees' => $topEmployees,
        ]);
    }
}
