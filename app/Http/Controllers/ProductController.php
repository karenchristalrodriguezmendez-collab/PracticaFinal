<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProductStoreRequest;
// use App\Http\Requests\ProductUpdateRequest;
use App\Models\ProductImage;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function index(Request $request)
    {
        return view("products.index", [
            "products" => collect(),
        ]);
    }

    public function show(Product $product)
    {
        return view("products.show", compact("product"));
    }

    public function create(Request $request)
    {
        return view("products.form");
    }

    public function store(Request $request)
    {
        try {
            $id = $request->input("id", null);

            $validated = $request->validate([
                "name" => [
                    "required",
                    "string",
                    "max:40",
                    "unique:products,name" . ($id ? "," . $id : ""),
                ],
                "price" => "required|numeric|min:1|max:9999999",
                "description" => "required|string",
                "image" => "nullable",
                "image.*" => "image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
            ], [
                'name.required' => 'El nombre del producto es obligatorio.',
                'name.unique' => 'Ya existe un producto con este nombre.',
                'name.max' => 'El nombre no debe exceder los 40 caracteres.',
                'price.required' => 'El precio es obligatorio.',
                'price.numeric' => 'El precio debe ser un número.',
                'price.min' => 'El precio debe ser de al menos 1.',
                'description.required' => 'La descripción es obligatoria.',
            ]);

            $productData = $validated;
            unset($productData['image']);
            unset($productData['deleted_images']);

            if ($id) {
                $product = Product::findOrFail($id);
                $product->update($productData);
                $message = "Producto actualizado exitosamente.";
            } else {
                $product = Product::create($productData);
                $message = "Producto guardado exitosamente.";
            }

            // Procesar múltiples imágenes
            if ($request->hasFile("image")) {
                $hasExistingPrimary = $product->images()->where('is_primary', true)->exists();
                $files = is_array($request->file("image")) ? $request->file("image") : [$request->file("image")];
                
                foreach ($files as $index => $file) {
                    $uploadResult = $this->fileService->upload($file, "products");

                    if ($uploadResult["success"]) {
                        $isPrimary = !$hasExistingPrimary && $index === 0;
                        $product->images()->create([
                            "image_path" => $uploadResult["path"],
                            "is_primary" => $isPrimary,
                        ]);

                        // Mantener compatibilidad con columna legacy (opcional)
                        if ($isPrimary) {
                            $product->image = $uploadResult["path"];
                            $product->save();
                        }
                    }
                }
            }

            return redirect()
                ->route("products.index")
                ->with("success", $message);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                "name" => [
                    "required",
                    "string",
                    "max:40",
                    "unique:products,name," . $product->id
                ],
                "price" => "required|numeric|min:1|max:9999999",
                "description" => "required|string",
                "image" => "nullable|array",
                "image.*" => "image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
                "deleted_images" => "nullable|array",
            ], [
                'name.required' => 'El nombre del producto es obligatorio.',
                'name.unique' => 'Ya existe un producto con este nombre.',
                'name.max' => 'El nombre no debe exceder los 40 caracteres.',
                'price.required' => 'El precio es obligatorio.',
                'price.numeric' => 'El precio debe ser un número.',
                'price.min' => 'El precio debe ser de al menos 1.',
                'description.required' => 'La descripción es obligatoria.',
            ]);

            $productData = $validated;
            unset($productData['image']);
            unset($productData['deleted_images']);

            $product->update($productData);

            // Eliminar imágenes marcadas
            if ($request->has("deleted_images")) {
                foreach ($request->input("deleted_images") as $imageId) {
                    $img = ProductImage::find($imageId);
                    if ($img && $img->product_id === $product->id) {
                        $this->fileService->delete($img->image_path);
                        $img->delete();
                    }
                }
            }

            // Procesar nuevas imágenes
            if ($request->hasFile("image")) {
                $hasExistingPrimary = $product->images()->where('is_primary', true)->exists();
                foreach ($request->file("image") as $index => $file) {
                    $uploadResult = $this->fileService->upload($file, "products");

                    if ($uploadResult["success"]) {
                        $product->images()->create([
                            "image_path" => $uploadResult["path"],
                            "is_primary" => !$hasExistingPrimary && $index === 0,
                        ]);

                        // Actualizar legacy si no hay primaria o esta es la nueva primera
                        if (!$hasExistingPrimary && $index === 0) {
                            $product->image = $uploadResult["path"];
                            $product->save();
                        }
                    }
                }
            }

            return redirect()
                ->route("products.index")
                ->with("success", "Producto actualizado exitosamente.");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function edit(Request $request, Product $product)
    {
        //$product = Product::find($product);

        return view("products.form", [
            "product" => $product,
        ]);
    }

    // public function update(ProductUpdateRequest $request, Product $product)
    // {
    //     $product->update($request->validated());

    //     session()->flash('Product.name', $product->name);

    //     return redirect()->route('products.index');
    // }

    public function destroy(Request $request, Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            $this->fileService->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route("products.index")
            ->with("success", "Producto eliminado exitosamente!!!");
    }

    public function dataTable(Request $request)
    {
        try {
            // Validar params de DataTables
            $request->validate([
                "draw" => "integer",
                "start" => "integer|min:0",
                "length" => "integer|min:1|max:100",
                "search.value" => "nullable|string|max:255",
            ]);

            // Query base con eager loading para evitar N+1
            $query = Product::with('images');

            // Búsqueda en varios campos
            $search = $request->input("search.value");
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where("name", "like", "%{$search}%")
                        ->orWhere("description", "like", "%{$search}%")
                        ->orWhere("price", "like", "%{$search}%");
                });
            }

            // Total de registros sin filtros (para recordsTotal)
            $totalRecords = Product::count();

            // Total de registros filtrados (recordsFiltered)
            $recordsFiltered = $query->count();

            // Ordenación
            $columns = ["id", "name", "description", "price", "id"];
            $orderColumn = $request->input("order.0.column", 0);
            $orderDir = $request->input("order.0.dir", "desc");
            $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

            // Paginación
            $start = $request->input("start", 0);
            $length = $request->input("length", 10);
            $products = $query->offset($start)->limit($length)->get();

            // Formatear los datos
            $data = $products->map(function ($product) {
                $imageHtml = "";
                // Usar la relación ya cargada ansiosamente
                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                
                if ($primaryImage && Storage::disk("public")->exists($primaryImage->image_path)) {
                    $imageHtml =
                        '<img src="' .
                        asset("storage/" . $primaryImage->image_path) .
                        '" alt="' .
                        $product->name .
                        '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
                } elseif (
                    $product->image &&
                    Storage::disk("public")->exists($product->image)
                ) {
                    $imageHtml =
                        '<img src="' .
                        asset("storage/" . $product->image) .
                        '" alt="' .
                        $product->name .
                        '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
                } else {
                    $imageHtml =
                        '<div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;"><i class="bi bi-image text-muted"></i></div>';
                }

                return [
                    "image" => $imageHtml,
                    "name" => $product->name,
                    "description" => $product->description,
                    "price" => '$' . number_format($product->price, 2),
                    "actions" =>
                        '
                        <div class="d-flex gap-1">
                            <button class="btn btn-primary btn-sm" onclick="execute(\'/products/' .
                        $product->id .
                        '/edit\')">
                                <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Edit</span>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteRecord(\'/products/' .
                        $product->id .
                        '\')">
                                <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Delete</span>
                            </button>
                        </div>
                    ',
                ];
            });

            // Respuesta JSON en formato requerido por DataTables
            return response()->json([
                "draw" => (int) $request->input("draw"),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data,
            ]);
        } catch (\Exception $e) {
            Log::error("Error en ProductController@dataTable: " . $e->getMessage());
            return response()->json([
                "draw" => (int) $request->input("draw", 0),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => "Error interno al cargar los datos: " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar imagen de producto
     */
    public function downloadImage(Product $product)
    {
        if (!$product->image) {
            abort(404, "Imagen no encontrada");
        }

        try {
            return $this->fileService->download(
                $product->image,
                "producto_" . $product->id . "_" . basename($product->image),
            );
        } catch (\Exception $e) {
            abort(404, "Archivo no encontrado");
        }
    }
}
