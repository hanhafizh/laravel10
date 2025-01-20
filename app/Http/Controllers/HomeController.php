<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        // pembatasan permission di controller
        // $this->middleware(['role:admin|writer']);
        // $this->middleware(['role_or_permission:writer|view_dashboard']);
    }
    public function dashboard()
    {
        // # Pembatasan roles melalui controller
        // dd(auth()->user()->getRoleNames());
        // if (auth()->user()->can('view_dashboard')) {
        //     return view('dashboard');
        // }
        // return abort(403);
        return view('dashboard');
    }

    public function index(Request $request)
    {
        // $data = User::get();
        $data = new User;

        if ($request->get('search')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('index', compact('data', 'request'));
    }

    public function asset(Request $request)
    {
        // many to many relation
        // $data = User::get();
        $data = new User;

        if ($request->get('search')) {
            $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('assets', compact('data', 'request'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'     => 'required|mimes:png,jpg,jpeg|max:2048',
            'email'     => 'required|email|unique:users,email',
            'name'      => 'required|string|max:255',
            'password'  => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('success', 'File uploaded successfully')->withInput()->withErrors($validator);
        }

        // Proses unggah gambar
        $image      = $request->file('image');
        $uniqueId   = uniqid();
        $filename   = $uniqueId . '_' . $image->getClientOriginalName();
        $path       = 'photo-user/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        // Data yang akan disimpan
        $data = [
            'email'     => $request->email,
            'name'      => $request->name,
            'password'  => Hash::make($request->password),
            'image'     => $filename,
        ];

        User::create($data);

        return redirect()->route('admin.user.index')->with('success_add_user', 'Kamu berhasil menambahkan User');
    }

    public function edit(Request $request, $id)
    {
        $data = User::findOrFail($id);

        return view('edit', compact('data'));
    }

    // one to many, details
    public function detail(Request $request, $id)
    {
        $data = User::findOrFail($id);

        return view('detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image'     => 'mimes:jpeg,png,jpg|max:2048',
            'email'     => 'required|email|unique:users,email,' . $id,
            'name'      => 'required|string|max:255',
            'password'  => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = User::findOrFail($id); // Temukan user berdasarkan ID
        $data = [
            'email' => $request->email,
            'name'  => $request->name,
        ];

        // Proses unggah gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image && Storage::disk('public')->exists('photo-user/' . $user->image)) {
                Storage::disk('public')->delete('photo-user/' . $user->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $uniqueId = uniqid();
            $filename = $uniqueId . '_' . $image->getClientOriginalName();
            $path = 'photo-user/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($image));
            $data['image'] = $filename;
        }

        // Hash password jika ada perubahan
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // Update data user
        $user->update($data);

        return redirect()->route('admin.user.index')->with('success_update_user', 'Kamu berhasil update User');
    }



    public function delete($id)
    {
        $data = User::find($id);

        if ($data) {
            // Hapus file gambar dari storage
            if ($data->image && Storage::disk('public')->exists('photo-user/' . $data->image)) {
                Storage::disk('public')->delete('photo-user/' . $data->image);
            }

            // Hapus data dari database
            $data->delete();
        }

        return redirect()->route('admin.user.index')->with('success_delete_user', 'Kamu berhasil delete User');
    }
}
