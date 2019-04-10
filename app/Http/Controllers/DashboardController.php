<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $dashboard['classroom'] = Classroom::all()->count();
        $dashboard['course'] = Course::all()->count();
        $dashboard['lecturer'] = User::whereRole('dosen')->get()->count();
        $dashboard['student'] = User::whereRole('mahasiswa')->get()->count();

        return view('dashboard.index', compact('dashboard'));
    }
}
