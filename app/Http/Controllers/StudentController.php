<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\updateStudentRequest;
use App\Http\Resources\StudentsResource;
use App\Models\Students;
use App\Models\Schools;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Students = Students::all() ;
        return $this->respond(StudentsResource::collection($Students)) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStudentRequest $request)
    {
        $data = $request->validated();

        $school = Schools::findOrFail($data['school_id']);

        $lastColumn = Students::where('school_id',$school->id)->latest()->first();

        $data['ordernumber'] = $lastColumn->ordernumber + 1 ;

        $student = $school->students()->create($data);
        return $this->respond(new StudentsResource($student));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Student = Students::findOrFail($id) ;
        return $this->respond(new StudentsResource($Student)) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateStudentRequest $request, $id)
    {
        $student = Students::findOrFail($id);

        $student->update($request->validated());
        return $this->respond(new StudentsResource($student)) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Student = Students::findOrFail($id) ;

        $student->delete();

        return $this->respondDeleted(); 
    }
}
