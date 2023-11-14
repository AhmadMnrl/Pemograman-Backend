<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class StudentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->except(['index', 'show']);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get all students
        $students = Student::query();

        // Filter by name if provided
        $name = $request->input('filter.nama');
        if ($name) {
            $students->where('nama', $name);
        }

        // Get sorting parameters
        $order = $request->input('filter.order', 'asc');
        $sort = $request->input('filter.sort', 'nama');

        // Pagination parameters
        $pageLimit = $request->input('page.limit', 1);
        $pageNumber = $request->input('page.number', 1);
        $offset = ($pageNumber - 1) * $pageLimit;

        // Apply sorting and pagination
        $students->orderBy($sort, $order)->offset($offset)->limit($pageLimit);

        // Get total count for pagination
        $studentTotal = Student::query();
        if ($name) {
            $studentTotal->where('nama', $name);
        }
        $totalData = $studentTotal->count();
        $totalPage = ceil($totalData / $pageLimit);

        // Prepare response data
        $pages = [
            'pageLimit' => (int)$pageLimit,
            'pageNumber' => (int)$pageNumber,
            'totalData' => $totalData,
            'totalPage' => $totalPage,
        ];

        $data = [
            'pages' => $pages,
            'table' => $students->get(),
        ];
        if ($data['table']->count() > 0) {
            $result = [
                'message' => 'Success Get All Users',
                'data' => $data,
            ];
        } else {
            $result = [
                'message' => 'Data not found',
            ];
        }
        return response()->json($result, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required|email',
            'jurusan' => 'required',
        ]);
        $student = Student::create($validatedData);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = (int) $id;
        $student = Student::find($id);
        if (!$student) {
            return response()->json(["message" => "Data Not Found"], 404);
        }
        $validatedData = $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required|email',
            'jurusan' => 'required',
        ]);
        $student->update($validatedData);
        $data = [
            'message' => "Student is updated successfully",
            'data' => $student
        ];
        return response()->json($data, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int) $id;
        $student = Student::find($id);
        if (!$student) {
            return response()->json(["message" => "Data Not Found"], 404);
        }
        $student->delete();
        $data = [
            'message' => "Student is deleted successfully",
            'data' => $student
        ];
        return response()->json($data, 200);
    }
    public function show($id)
    {
        $id = (int) $id;
        $student = Student::find($id);
        if (!$student) {
            return response()->json(["message" => "Data Not Found"], 404);
        }
        $data = [
            "message" => "Get Student Detail",
            "data" => $student
        ];
        return response()->json($data, 200);
    }
}
