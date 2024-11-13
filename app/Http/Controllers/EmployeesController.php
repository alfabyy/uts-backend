<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employees::All(); 

        if ($employees) {
            $data = [
                'message' => 'Berhasil akses data',
                'data' => $employees
            ];

            return response()->json($data,200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'required|email',
            'status' => 'required|string|max:255',
            'hired_on' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $employees = Employees::create($request->all());
    
        $data = [
            'message' => 'Berhasil menambah data',
            'data' => $employees
        ];
        
        return response()->json($data, 201);
    }

    public function show(string $id)
    {
        $employees = Employees::find($id);

        if ($employees) {
            return response()->json($employees, 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan!'], 404);
    }

    public function update(Request $request, string $id)
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $input = [
            'name' => $request->name ?? $employees->name,
            'gender' => $request->gender ?? $employees->gender,
            'phone' => $request->phone ?? $employees->phone,
            'address' => $request->address ?? $employees->address,
            'email' => $request->email ?? $employees->email,
            'status' => $request->status ?? $employees->status,
            'hired_on' => $request->hired_on ?? $employees->hired_on,
        ];

        $employees->update($input);

        $data = [
            'message' => 'Berhasil mengubah data',
            'data' => $employees,
        ];

        return response()->json($data, 200);
    }

    public function destroy(string $id)
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $employees->delete();

        $data = [
            'message' => 'Berhasil menghapus data',
            'data' => $employees,
        ];

        return response()->json($data, 200);
    }
}
