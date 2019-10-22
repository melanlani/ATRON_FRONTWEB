<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
    	// mengambil data dari table pegawai
    	$users = DB::table('users')->get();

    	// mengirim data pegawai ke view index
    	return view('user',['users' => $users]);
    }

    public function store(Request $request)
	{
		// insert data ke table pegawai
		DB::table('users')->insert([
			'name' => $request->name,
			'username' => $request->username,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role' => $request->role
		]);
		// alihkan halaman ke halaman pegawai
		return redirect('/user');
	 
	}

	public function edit($id)
	{
		// mengambil data pegawai berdasarkan id yang dipilih
		$user = DB::table('users')->where('id',$id)->get();
		// passing data pegawai yang didapat ke view edit.blade.php
		return view('user',['user' => $user]);

	}

	public function delete($id)
	{
		// menghapus data pegawai berdasarkan id yang dipilih
		DB::table('users')->where('id',$id)->delete();
			
		// alihkan halaman ke halaman pegawai
		return redirect('/user');
	}
}
