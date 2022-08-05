<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Cabang;
use App\Http\Controllers\Controller;
use App\Http\Requests\DokterRequest;
use App\Jadwal;
use App\Shift;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = User::with('cabang')->role('dokter')->get();

        return view('admin.dokter.index', compact('dokter'));
    }

    public function create()
    {
        return view('admin.dokter.create', [
            'dokter' => new User(),
            'cabang' => Cabang::get()
        ]);
    }

    public function store(DokterRequest $request)
    {
        $attr = $request->all();
        $image = $request->file('image');
        $imageUrl = $image->storeAs('images/users', \Str::random(15) . '.' . $image->extension());

        $attr['image'] = $imageUrl;
        $attr['is_active'] = 1;
        $attr['password'] = Hash::make($request->password);

        $user = User::create($attr);

        $user->assignRole(2);

        return redirect()->route('admin.dokter.index')->with('success', 'Doctor has been added');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.dokter.show', [
            'dokter' => $user,
            'booking' => Booking::where('dokter_id', $user->id)->get(),
            'shift' => Shift::get(),
            'attendance' => Jadwal::where('user_id', $user->id)->whereMonth('tanggal', Carbon::now()->format('m'))->whereYear('tanggal', Carbon::now()->format('Y'))->get()
        ]);
    }

    public function edit($id)
    {
        // return view('dokter.profile.edit', [
        //     'dokter' => User::find($id)
        // ]);
        return view('admin.dokter.edit', [
            'dokter' => User::find($id),
            'cabang' => Cabang::get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $attr = $request->all();
        $user = User::find($id);

        if ($request->input('password') == null) {
            $attr['password'] = $user->password;
        } else {
            $attr['password'] =  Hash::make($request->password);
        }

        $image = $request->file('image');

        if ($request->file('image')) {
            Storage::delete($user->image);
            $imageUrl = $image->storeAs('images/users', \Str::random(15) . '.' . $image->extension());
            $attr['image'] = $imageUrl;
        } else {
            $attr['image'] = $user->image;
        }

        $user->update($attr);

        return redirect()->route('admin.dokter.index')->with('success', 'Doctor has been updated');
    }

    public function destroy($id)
    {
        //
    }
    public function resign($id)
    {
        $dokter = User::findOrFail($id);
        if ($dokter->is_active == 2) {
            $dokter->update([
                'is_active' => 1
            ]);
        } else {
            $dokter->update([
                'is_active' => 2
            ]);
        }
        return back()->with('success', "Berhasil Mengubah Status");
    }
}
