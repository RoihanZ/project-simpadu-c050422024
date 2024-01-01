<?php

namespace App\Http\Controllers\Api;
use App\Models\Schedule;
use App\Http\Resources\ScheduleResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $user = $request->user();
        // $schedules = Schedule::where('student_id', '=', $user->id)->get();
        return ScheduleResource::collection(Schedule::all());
    }


}
