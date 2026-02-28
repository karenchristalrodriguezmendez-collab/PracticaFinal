@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Color Palette Verification</div>
                <div class="card-body">
                    <h5>Tailwind CSS Classes</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <div class="p-3 bg-brand-cream border text-black rounded">bg-brand-cream</div>
                        <div class="p-3 bg-brand-tan text-white rounded">bg-brand-tan</div>
                        <div class="p-3 bg-brand-olive text-white rounded">bg-brand-olive</div>
                        <div class="p-3 bg-brand-green text-white rounded">bg-brand-green</div>
                        <div class="p-3 bg-brand-black text-white rounded">bg-brand-black</div>
                    </div>

                    <h5>SCSS/CSS Variables (Style attribute)</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="p-3 border rounded" style="background-color: var(--brand-cream); color: black;">--brand-cream</div>
                        <div class="p-3 rounded" style="background-color: var(--brand-tan); color: white;">--brand-tan</div>
                        <div class="p-3 rounded" style="background-color: var(--brand-olive); color: white;">--brand-olive</div>
                        <div class="p-3 rounded" style="background-color: var(--brand-green); color: white;">--brand-green</div>
                        <div class="p-3 rounded" style="background-color: var(--brand-black); color: white;">--brand-black</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
