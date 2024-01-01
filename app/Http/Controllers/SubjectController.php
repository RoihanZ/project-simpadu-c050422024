<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subjects = Subject::with('lecturer')
        ->when($request->input('title'), function($query, $title){
            return $query->where('title', 'like', '%' . $title . '%');
        })
        ->select('id', 'title', 'lecturer_id', 'created_at', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as formatted_date'))
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('pages.subject.index', compact('subjects'));
    }

    public function create(User $user)
    {
        $users = $user::all();
        return view('pages.subject.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        Subject::create([
            'title' => $request['title'],
            'lecturer_id' => $request['lecturer_id']
        ]);

        return redirect(route('subject.index'))->with('success', 'Data berhasil disimpan!');
    }

    public function edit(Subject $subject)
    {
        $lecturers = User::all(); // Assuming User model represents lecturers
        return view('pages.subject.edit', compact('subject', 'lecturers'));
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
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validate = $request->validated();
        $subject->update($validate);
        return redirect()->route('subject.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subject.index')->with('success', 'Data berhasil dihapus!');
    }
}
