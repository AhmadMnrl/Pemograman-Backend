<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth; // autentikasi Laravel
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    // Metode untuk registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        // Jika validasi gagal, kembalikan respons berisi pesan kesalahan
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $key => $value) {
                return response()->json(["error"=>$value]);       
            }
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Kembalikan respons berisi data pengguna dan token
        return response()
            ->json(['message'=>'Successfully register']);
    }

    // Metode untuk proses login pengguna
    public function login(Request $request)
    {
        // Coba melakukan autentikasi pengguna dengan email dan password yang diberikan
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Jika autentikasi gagal, kembalikan respons Unauthorized
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }
        // Temukan pengguna berdasarkan email
        $user = User::where('email', $request['email'])->firstOrFail();

        // Buat token untuk pengguna yang berhasil login
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan respons berisi pesan selamat datang dan token
        return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    // Metode untuk logout pengguna dan menghapus token
    public function logout()
    {
        // Menghapus semua token yang terkait dengan pengguna yang saat ini diotentikasi
        auth()->user()->tokens()->delete();

        // Kembalikan pesan logout sukses
        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
