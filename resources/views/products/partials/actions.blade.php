<div class="d-flex gap-2 justify-content-center">
    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-success btn-sm rounded-pill" title="Ver Detalles">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm rounded-pill" title="Editar">
        <i class="bi bi-pencil"></i>
    </a>
    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" 
            onclick="deleteRecord('{{ route('products.destroy', $product) }}')" title="Eliminar">
        <i class="bi bi-trash"></i>
    </button>
</div>
