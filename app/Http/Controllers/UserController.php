<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        try {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
        } catch (\Exception $e) {
            return redirect()->route('users.create')->with('error', 'Erro ao criar o usuário: Verifique as informações enviadas');
        }

        return redirect()->route('users.index')->with('message', 'Usuário criado com sucesso');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');

        try {
            $user->name = $name;
            $user->email = $email;
            $user->role = $role;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->route('users.edit', ['id' => $id])->with('error', 'Erro ao atualizar o usuário: Verifique as informações enviadas');
        }

        return redirect()->route('users.index')->with('message', 'Usuário atualizado com sucesso');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Erro ao excluir o usuário: Verifique as informações enviadas');
        }

        return redirect()->route('users.index')->with('message', 'Usuário excluído com sucesso');
    }

}
