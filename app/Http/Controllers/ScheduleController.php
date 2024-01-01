<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = Schedule::with('subject')
        ->when($request->input('subject_id'), function($query, $subject_id){
            return $query->where('subject_id', 'like', '%' . $subject_id . '%');
        })
        ->select('id', 'subject_id', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan', DB::raw('DATE_FORMAT (created_at, "%d %M %Y") as formatted_date'))
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('pages.schedule.index', compact('schedules'));
    }

    public function create(Subject $subject, User $user){
        $subjects = $subject::all();
        return view('pages.schedule.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        Schedule::create([
            'subject_id' => $request['subject_id'],
            'hari' => $request['hari'],
            'jam_mulai' => $request['jam_mulai'],
            'jam_selesai' => $request['jam_selesai'],
            'ruangan' => $request['ruangan'],
        ]);

        return redirect(route('schedule.index'))->with('success', 'Data berhasil disimpan!');
    }

    public function edit(Schedule $schedule){
        $subject = Subject::all();
        return view('pages.schedule.edit', compact('schedule', 'subject'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $validate = $request->validated();
        $schedule->update($validate);
        return redirect()->route('schedule.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Data berhasil dihapus!');

    }
}
