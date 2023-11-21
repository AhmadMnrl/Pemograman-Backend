<?php

namespace App\Http\Controllers;

use App\Models\Patients; //model Patients
use App\Models\StatusPatients; //model status patients
use Illuminate\Http\Request; //Mengimpor kelas Request dari framework Laravel untuk mengelola permintaan HTTP
use Validator; //Mengimpor fasad validasi dari laravel untuk memvalidasi data
use Illuminate\Validation\ValidationException; //Mengimpor kelas ValidationException yang digunakan untuk menangani pengecualian terkait validasi

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $patients = Patients::with('status');

            // Validasi status yang dapat diterima
            $allowedStatus = ['sakit', 'meninggal', 'sembuh'];
            $statusFilter = $request->input('status');
            if ($statusFilter && !in_array($statusFilter, $allowedStatus)) {
                return response()->json(['status' => 400, 'message' => 'Invalid status filter. Accepted values: sakit, meninggal, sembuh'], 400);
            }

            // Filtering
            /* Array assosiatif yang digunakan sebagai tampungan untuk data filter, sebaiknya apabila data yang ditampung kurang dari 5 lebih baik di deklarasikan langsung tanpa perlu ditampung kedalam variable, 
            tapi kali ini saya memakai array assosiatif
            */
            $filters = [
                'name' => 'name',
                'address' => 'address',
                'status' => 'status',
            ];

            // perulangan yang digunakan untuk mencari nilai data tampungan dari variable "$filters"
            foreach ($filters as $key => $column) {
                $value = $request->input($key);
                if ($value) {
                    if ($key === 'status') {
                        $patients->whereHas('status', function ($query) use ($key, $value) {
                            $query->where($key, 'LIKE', '%' . $value . '%');
                        });
                    } else {
                        $patients->where($column, 'LIKE', '%' . $value . '%');
                    }
                }
            }
            //End

            // Sorting
            $order = $request->input('order', 'asc');
            $sort = $request->input('sort', 'name');

            // var_dump($order);
            // var_dump($sort);
            // Validate allowed sorting columns
            // Validasi untuk sorting kolom
            $allowedSortColumns = ['name', 'in_date_at', 'out_date_at', 'address'];
            if (!in_array($sort, $allowedSortColumns)) {
                return response()->json(['status' => 400, 'message' => 'Invalid sort column'], 400);
            }

            // Pagination untuk membatasi data yang tampilkan 
            $pageLimit = $request->input('PageLimit', 10);
            $pageNumber = $request->input('PageNumber', 1);
            $offset = ($pageNumber - 1) * $pageLimit;

            // Data yang akan ditampilkan dari variable $patients akan dibatasi sesuai dengan kriteria yang diinginkan
            $patients
                ->orderBy($sort, $order)
                ->offset($offset)
                ->limit($pageLimit);

            // Komputasi untuk mendapatkan nilai total data
            $totalData = $patients->count();
            $totalPage = ceil($totalData / $pageLimit);

            // kondisi jika data tidak ada
            if ($totalData < 1) {
                return response()->json(["status"=> 404, "message"=> "Data Not Found"],404);
            }
            // Response data yang ditampilkan
            $pages = [
                'pageLimit' => (int) $pageLimit,
                'pageNumber' => (int) $pageNumber,
                'totalData' => $totalData,
                'totalPage' => $totalPage,
            ];

            $data = [
                'pages' => $pages,
                'table' => $patients->get(),
            ];

            $status = $data['table']->count() > 0 ? 200 : 404;
            // Result hasil dengan menggunakan JSON
            return response()->json([
                'status' => $status,
                'message' => 'Get All Patients',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Handle database-related errors
            return response()->json(
                [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:100',
                'phone' => 'required|min:10',
                'address' => 'required',
                'status' => 'required|in:sakit, meninggal,sembuh',
                'in_date_at' => 'nullable|date',
                'out_date_at' => 'nullable|date',
            ],[
                'status.in' => 'The status field must be one of: sakit, meninggal, sembuh.'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 422,
                        'message' => 'Failed Added Data',
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            }
            //end validasi

            // Fungsi untuk jika tidak menginputkan nilai in dan out date, akan otomatis disini date now
            $in_date_at = $request->in_date_at ? (new \DateTime($request->in_date_at))->format('Y-m-d') : date('Y-m-d');
            $out_date_at = $request->out_date_at ? (new \DateTime($request->out_date_at))->format('Y-m-d') : null;

            // Simpan data
            $statusPatient = StatusPatients::create([
                'status' => $request->status,
                'in_date_at' => $in_date_at,
                'out_date_at' => $out_date_at,
            ]);

            $patient = Patients::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'status_id' => $statusPatient->id,
            ]);
            // Membuat respons JSON
            if ($patient) {
                return response()->json(
                    [
                        'status' => 201,
                        'message' => 'Patients is created successfully',
                    ],
                    201,
                );
            } else {
                return response()->json(
                    [
                        'status' => 422,
                        'message' => 'Error creating patients',
                    ],
                    422,
                );
            }
        } catch (\Exception $e) {
            // Handle database-related errors
            return response()->json(
                [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
    public function show($id)
    {
        $patients = Patients::with('status')->find($id);
        if (!$patients) {
            return response()->json(['status' => 404, 'message' => 'Data Not Found'], 404);
        }
        // Membuat respons JSON
        $data = [
            'status' => 200,
            'message' => 'Get Patients Detail',
            'data' => $patients,
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'name' => 'max:100',
                'phone' => 'min:10',
                'status' => 'nullable|in:sakit, meninggal,sembuh',
            ],[
                'status.in' => 'The status field must be one of: sakit, meninggal, sembuh.'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 422,
                        'message' => 'Failed Update Data',
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            }
            //end validasi
            $findDataPatients = Patients::find($id);
            if ($findDataPatients == null) {
                return response()->json(['message' => 'data not found'], 404);
            }
            $findDataStatusPatients = StatusPatients::find($findDataPatients->id);

            if (!isset($request->in_date_at)) {
                $in_date_at = $findDataStatusPatients->in_date_at;
            } else {
                $in_date_at = new \DateTime($request->in_date_at);
                $in_date_at = $in_date_at->format('Y-m-d');
            }

            if (!isset($request->out_date_at)) {
                $out_date_at = $findDataStatusPatients->out_date;
            } else {
                $out_date_at = new \DateTime($request->out_date_at);
                $out_date_at = $out_date_at->format('Y-m-d');
            }

            $inputStatusPatients = [
                'status' => isset($request->status) ? $request->status : $findDataStatusPatients->status,
                'in_date_at' => $in_date_at,
                'out_date_at' => $out_date_at,
            ];

            $statusPatients = StatusPatients::where('id', $findDataStatusPatients->status_id)->update($inputStatusPatients);
            $inputPatients = [
                'name' => isset($request->name) ? $request->name : $findDataPatients->name,
                'phone' => isset($request->phone) ? $request->phone : $findDataPatients->phone,
                'address' => isset($request->address) ? $request->address : $findDataPatients->address,
                'status_id' => $findDataPatients->status_id,
            ];
            $patients = Patients::where('id', $findDataPatients->id)->update($inputPatients);
            $data = [
                'message' => 'Patients is updated successfully',
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            // Handle database-related errors
            return response()->json(
                [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
    public function destroy($id)
    {
        try {
            $patients = Patients::find($id);
            if (!$patients) {
                return response()->json(['message' => 'Data Not Found'], 404);
            }
            // Retrieve the related status record
            $statusPatients = $patients->status;

            // hapus patients record
            $patients->delete();

            // hapus status record
            if ($statusPatients) {
                $statusPatients->delete();
            }
            // Membuat respons JSON
            $data = [
                'status' => 200,
                'message' => 'Patients is deleted successfully',
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Handle database-related errors
            return response()->json(
                [
                    'status' => 500,
                    'message' => 'Internal Server Error',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
