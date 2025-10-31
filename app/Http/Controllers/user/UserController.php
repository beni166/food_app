<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
  {
    $user = auth()->user();
    return view('user.dashbord', compact('user'));
  }

  //afficher les info du user
  public function edit()
  {
    $user = auth()->user();
    return view('user.profile.profile', compact('user'));
  }

  public function update(ProfileUpdateRequest $request)
  {
    $user = auth()->user();

    // Infos basiques
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // ✅ Gestion de l’image
    if ($request->hasFile('profile')) {
      // Supprimer l'ancienne image si elle existe
      if ($user->profile && File::exists(public_path($user->profile))) {
        File::delete(public_path($user->profile));
      }

      $file = $request->file('profile');
      $fileName = "profile" . uniqid() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path("assets/profiles/"), $fileName);
      $user->profile = "assets/profiles/" . $fileName;
    }

    // ✅ Gestion du mot de passe
    if ($request->filled('current_password') && $request->filled('password')) {
      if (Hash::check($request->current_password, $user->password)) {
        $user->password = Hash::make($request->password);
      } else {
        return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
      }
    }

    $user->save();

    return redirect()->route('user.dashboard')
      ->with('success', 'Profil mis à jour avec succès !');
  }
}
