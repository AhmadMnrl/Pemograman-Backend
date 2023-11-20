<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\StatusPatients;
use Illuminate\Http\Request;
use Validator;

/**
 * @group Patients
 *
 * APIs for managing patients.
 */
class PatientSwaggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam name string Search by patient name. Example: John
     * @queryParam address string Search by patient address. Example: 123 Main St
     * @queryParam status string Search by patient status. Example: Active
     * @queryParam sort string Sort the results by a specific column. Example: name
     * @queryParam order string Sort order (asc or desc). Example: asc
     * @queryParam PageLimit int Number of items per page. Example: 10
     * @queryParam PageNumber int Page number. Example: 1
     *
     * @response {
     *   "status": 200,
     *   "message": "Get All Patients",
     *   "data": {
     *     "pages": {
     *       "pageLimit": 10,
     *       "pageNumber": 1,
     *       "totalData": 20,
     *       "totalPage": 2
     *     },
     *     "table": [
     *       {
     *         "id": 1,
     *         "name": "John Doe",
     *         "phone": "1234567890",
     *         "address": "123 Main St",
     *         "status": {
     *           "id": 1,
     *           "status": "Active",
     *           "in_date_at": "2023-01-01",
     *           "out_date_at": null
     *         }
     *       },
     *       // ... more patient objects
     *     ]
     *   }
     * }
     *
     * @response status=404 {
     *   "status": 404,
     *   "message": "Data not found"
     * }
     */
    public function index(Request $request)
    {
        // Your existing code
    }

    /**
     * Store a newly created resource in storage.
     *
     * @bodyParam name string required Patient name. Example: John Doe
     * @bodyParam phone string required Patient phone number. Example: 1234567890
     * @bodyParam address string required Patient address. Example: 123 Main St
     * @bodyParam status string required Patient status. Example: Active
     * @bodyParam in_date_at date nullable Patient in-date. Example: 2023-01-01
     * @bodyParam out_date_at date nullable Patient out-date. Example: 2023-02-01
     *
     * @response {
     *   "status": 201,
     *   "message": "Patients is created successfully"
     * }
     *
     * @response status=422 {
     *   "status": 422,
     *   "message": "Failed Added Data",
     *   "errors": {
     *     "name": ["The name field is required."],
     *     // ... more validation errors
     *   }
     * }
     *
     * @response status=500 {
     *   "status": 500,
     *   "message": "Internal Server Error",
     *   "error": "Error message details"
     * }
     */
    public function store(Request $request)
    {
        // Your existing code
    }

    /**
     * Display the specified resource.
     *
     * @urlParam id int required The ID of the patient. Example: 1
     *
     * @response {
     *   "status": 200,
     *   "message": "Get Patients Detail",
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "phone": "1234567890",
     *     "address": "123 Main St",
     *     "status": {
     *       "id": 1,
     *       "status": "Active",
     *       "in_date_at": "2023-01-01",
     *       "out_date_at": null
     *     }
     *   }
     * }
     *
     * @response status=404 {
     *   "status": 404,
     *   "message": "Data Not Found"
     * }
     */
    public function show($id)
    {
        // Your existing code
    }

    /**
     * Update the specified resource in storage.
     *
     * @urlParam id int required The ID of the patient. Example: 1
     *
     * @bodyParam name string Patient name. Example: John Doe
     * @bodyParam phone string Patient phone number. Example: 1234567890
     * @bodyParam address string Patient address. Example: 123 Main St
     * @bodyParam status string Patient status. Example: Active
     * @bodyParam in_date_at date Patient in-date. Example: 2023-01-01
     * @bodyParam out_date_at date Patient out-date. Example: 2023-02-01
     *
     * @response {
     *   "status": 200,
     *   "message": "Patients is updated successfully"
     * }
     *
     * @response status=404 {
     *   "status": 404,
     *   "message": "Data not found"
     * }
     *
     * @response status=500 {
     *   "status": 500,
     *   "message": "Internal Server Error",
     *   "error": "Error message details"
     * }
     */
    public function update(Request $request, $id)
    {
        // Your existing code
    }
    /**
     * Remove the specified resource from storage.
     *
     * @urlParam id int required The ID of the patient. Example: 1
     *
     * @response {
     *   "status": 200,
     *   "message": "Patients is deleted successfully"
     * }
     *
     * @response status=404 {
     *   "status": 404,
     *   "message": "Data Not Found"
     * }
     *
     * @response status=500 {
     *   "status": 500,
     *   "message": "Internal Server Error",
     *   "error": "Error message details"
     * }
     */
    public function destroy($id)
    {
        
    }
}