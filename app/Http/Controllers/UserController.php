<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        return view("users.index", [
            "users" => collect(),
        ]);
    }

    public function create(Request $request)
    {
        return view("users.form");
    }

    public function store(Request $request)
    {
        try {
            Log::info("UserController: Store method called");

            $id = $request->input("id", null);

            $rules = [
                "name" => "required|string|max:255",
                "email" => ["required", "string", "email", "max:255", Rule::unique('users')->ignore($id)],
            ];

            if (!$id) {
                $rules["password"] = "required|string|min:8|confirmed";
            } else {
                $rules["password"] = "nullable|string|min:8|confirmed";
            }

            $validated = $request->validate($rules);

            if ($id) {
                // Actualizar usuario existente
                $user = User::findOrFail($id);
                $oldAvatar = $user->avatar;

                $user->name = $validated['name'];
                $user->email = $validated['email'];

                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }

                $user->save();

                // Procesar nuevo avatar si se subió
                if ($request->hasFile("avatar")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("avatar"),
                        "users"
                    );

                    if ($uploadResult["success"]) {
                        $user->avatar = $uploadResult["path"];
                        $user->save();

                        // Eliminar avatar anterior si existe
                        if ($oldAvatar) {
                            $this->fileService->delete($oldAvatar);
                        }
                    }
                }
            } else {
                // Crear usuario nuevo
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);

                // Procesar avatar para usuario nuevo
                if ($request->hasFile("avatar")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("avatar"),
                        "users"
                    );

                    if ($uploadResult["success"]) {
                        $user->avatar = $uploadResult["path"];
                        $user->save();
                    }
                }
            }

            return redirect()
                ->route("users.index")
                ->with("success", "Usuario registrado exitosamente.");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function edit(Request $request, User $user)
    {
        return view("users.form", [
            "user" => $user,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        // Eliminar avatar si existe
        if ($user->avatar) {
            $this->fileService->delete($user->avatar);
        }

        $user->delete();

        return redirect()
            ->route("users.index")
            ->with("success", "Usuario eliminado exitosamente!!!");
    }

    public function dataTable(Request $request)
    {
        $request->validate([
            "draw" => "integer",
            "start" => "integer|min:0",
            "length" => "integer|min:1|max:100",
            "search.value" => "nullable|string|max:255",
        ]);

        $query = User::query();

        $search = $request->input("search.value");
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%");
            });
        }

        $totalRecords = User::count();

        $filteredRecords = clone $query;
        $recordsFiltered = $filteredRecords->count();

        $columns = ["name", "email", "created_at", "id"];
        $orderColumn = $request->input("order.0.column", 0);
        $orderDir = $request->input("order.0.dir", "asc");
        $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

        $start = $request->input("start", 0);
        $length = $request->input("length", 10);
        $data = $query->skip($start)->take($length)->get();

        $data = $data->map(function ($user) {
            $avatarHtml = "";
            if (
                $user->avatar &&
                Storage::disk("public")->exists($user->avatar)
            ) {
                $avatarHtml =
                    '<img src="' .
                    asset("storage/" . $user->avatar) .
                    '" alt="' .
                    $user->name .
                    '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">';
            } else {
                $avatarHtml =
                    '<div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%;"><i class="bi bi-person text-muted"></i></div>';
            }

            return [
                "avatar" => $avatarHtml,
                "name" => $user->name,
                "email" => $user->email,
                "created_at" => $user->created_at->format('Y-m-d H:i'),
                "actions" =>
                    '
                    <button class="btn btn-primary btn-sm" onclick="execute(\'/users/' .
                    $user->id .
                    '/edit\')">
                        <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Edit</span>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteRecord(\'/users/' .
                    $user->id .
                    '\')">
                        <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Delete</span>
                    </button>
                ',
            ];
        });

        return response()->json([
            "draw" => (int) $request->input("draw"),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
        ]);
    }

    public function downloadAvatar(User $user)
    {
        if (!$user->avatar) {
            abort(404, "Avatar no encontrado");
        }

        try {
            return $this->fileService->download(
                $user->avatar,
                "usuario_" . $user->id . "_" . basename($user->avatar),
            );
        } catch (\Exception $e) {
            abort(404, "Archivo no encontrado");
        }
    }
}
