<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    public function clientside(Request $request)
    {
        $data = new User;

        // #manual
        // if ($request->get('search')) {
        //     $data = $data->where('name', 'LIKE', '%' . $request->get('search') . '%')
        //         ->orWhere('email', 'LIKE', '%' . $request->get('search') . '%');
        // }

        $data = $data->get();

        return view('datatable.clientside', compact('data', 'request'));
    }

    public function serverside(Request $request)
    {
        $data = User::query();

        // search
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('no', function ($data) use ($request) {
                    $start = $request->input('start', 0);
                    static $index = 0;
                    return $start + (++$index);
                })

                ->addColumn('photo', function ($data) {
                    return '<img src="' . asset('storage/photo-user/' . $data->image) . '" alt="" width="50">';
                })
                ->addColumn('nama', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('action', function ($data) {
                    return ' <a href="' . route('admin.user.edit', ['id' => $data->id]) . '" class="btn btn-primary"><i class="fas fa-pen"></i>Edit</a>
                             <a data-toggle="modal" data-target="#modal-hapus' . $data->id . '" href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Hapus</a>';
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        return view('datatable.serverside', compact('request'));
    }
}
