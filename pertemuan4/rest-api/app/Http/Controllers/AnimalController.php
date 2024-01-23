<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller
{
    private $data;

    public function __construct()
    {
        $this->data = ['Kucing', 'Ayam', 'Ikan'];
    }

    public function index()
    {
        if (empty($this->data)) {
            return response()->json(['message' => 'Data Animals kosong', 'data' => []], 404);
        }

        return response()->json(['message' => 'Menampilkan Data Animals', 'data' => $this->data]);
    }

    public function store(Request $request)
    {
        $newAnimal = $request->input('nama_hewan');

        if (empty($newAnimal)) {
            return response()->json(['message' => 'Nama hewan tidak boleh kosong'], 400);
        }

        array_push($this->data, $newAnimal);

        return response()->json(['message' => 'Hewan baru ditambahkan!', 'data' => $this->data]);
    }

    public function update(Request $request, $id)
    {
        if (!isset($this->data[$id])) {
            return response()->json(['message' => "Data hewan ID $id tidak ditemukan"], 404);
        }

        $updatedAnimal = $request->input('nama_hewan');

        if (empty($updatedAnimal)) {
            return response()->json(['message' => 'Nama hewan tidak boleh kosong'], 400);
        }

        $this->data[$id] = $updatedAnimal;

        return response()->json(['message' => "Data hewan ID $id telah diperbarui!", 'data' => $this->data]);
    }

    public function destroy($id)
    {
        if (!isset($this->data[$id])) {
            return response()->json(['message' => "Data hewan ID $id tidak ditemukan"], 404);
        }

        unset($this->data[$id]);

        return response()->json(['message' => "Data hewan ID $id telah dihapus!", 'data' => $this->data]);
    }
}
