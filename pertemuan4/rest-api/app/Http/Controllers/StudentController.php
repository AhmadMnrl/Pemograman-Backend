<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        if ($students) {
            $data = [
                "message" => "Get All Users",
                "data" => $students
            ];

            return response()->json($data, 200);
        } else {
            return response()->json(["message" => "Error fetching students"], 500);
        }
    }
    public function store(Request $request)
    {
        $input = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'jurusan' => $request->jurusan
        ];

        $student = Student::create($input);

        if ($student) {
            $data = [
                'message' => 'Student is created successfully',
                'data' => $student
            ];

            return response()->json($data, 201);
        } else {
            return response()->json(["message" => "Error creating student"], 500);
        }
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = (int) $id;
        $input = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'jurusan' => $request->jurusan
        ];
        $student = Student::find($id)->update($input);

        if ($student) {
            $data = [
                'message' => "Student is updated successfully",
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            return response()->json(["message" => "Error updating student"], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int) $id;
        $student = Student::destroy($id);

        if ($student) {
            $data = [
                'message' => "Student is deleted successfully",
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            return response()->json(["message" => "Error deleting student"], 500);
        }
    }

}
