@extends('cpanel.app')

@section('title','Inventario')

@section('content')

<div class="container py-4">

    <a href="{{ route('bienvenido') }}" style="
        position:fixed;
        top:150px; 
        right:20px;
        background:#b91c1c;
        color:white;
        width:45px;
        height:45px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
        text-decoration:none;
        box-shadow:0 3px 10px rgba(0,0,0,0.2);
        z-index:999;
    ">
        ✕
    </a>

    {{-- HEADER --}}
    <div style="
        background: linear-gradient(135deg, #b91c1c, #ffffff);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    ">
        <h2 style="margin:0; color:#111;">📦 Inventario General</h2>
        <p style="margin:0; color:#444;">Control de productos, materiales y proveedores</p>
    </div>

    {{-- BOTONES --}}
    <div style="margin-top:20px; display:flex; gap:10px; flex-wrap:wrap;">
        <button onclick="showTab('productos')" class="pill-btn red">🌹 Productos</button>
        <button onclick="showTab('materiales')" class="pill-btn green">📦 Materiales</button>
        <button onclick="showTab('proveedores')" class="pill-btn dark">🚚 Proveedores</button>
    </div>

    {{-- ================= PRODUCTOS ================= --}}
    <div id="productos" class="tab mt-4">
        <h4 style="color:#b91c1c;">🌹 Productos</h4>

        <div class="row">
            @forelse($productos as $p)
            <div class="col-md-4 mb-3">
                <div style="background:#fff; border-radius:14px; padding:15px; border:1px solid #eee;">
                    <h5>{{ $p->Nombre ?? 'Sin nombre' }}</h5>
                    <p>💲 ${{ $p->Precio ?? 0 }}</p>
                    <p>{{ $p->Descripcion ?? '' }}</p>
                </div>
            </div>
            @empty
                <p>No hay productos registrados.</p>
            @endforelse
        </div>
    </div>

    {{-- ================= MATERIALES ================= --}}
    <div id="materiales" class="tab mt-4" style="display:none;">
        <h4 style="color:#b91c1c;">📦 Materiales</h4>

        <button onclick="openMaterialForm()" class="pill-btn green" style="margin-bottom:15px;">
            ➕ Agregar Material
        </button>

        {{-- TABLA --}}
        <div id="tablaMateriales">
            <div style="
                background:white;
                border-radius:16px;
                padding:15px;
                box-shadow:0 6px 18px rgba(0,0,0,0.08);
            ">

<div style="
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    overflow-x:auto;
">

<table style="
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
    min-width:700px;
">

    {{-- HEADER --}}
    <thead>
        <tr style="
            background:#8b0000;
            color:white;
            text-align:left;
        ">
            <th style="padding:14px 16px; border-radius:10px 0 0 10px;">Material</th>
            <th style="padding:14px 16px;">Cantidad</th>
            <th style="padding:14px 16px;">Unidad</th>
            <th style="padding:14px 16px;">Estado</th>
            <th style="padding:14px 16px; border-radius:0 10px 10px 0;">Acciones</th>
        </tr>
    </thead>

    {{-- BODY --}}
    <tbody>

        @foreach($materiales as $m)
        <tr style="
            background:#fff;
            box-shadow:0 2px 6px rgba(0,0,0,0.05);
            border-radius:12px;
        "
        onmouseover="this.style.transform='scale(1.01)'"
        onmouseout="this.style.transform='scale(1)'"
        >

            <td style="padding:16px; font-weight:600; border-radius:12px 0 0 12px;">
                {{ $m->Descripcion }}
            </td>

            <td style="padding:16px;">
                {{ $m->Cantidad }}
            </td>

            <td style="padding:16px;">
                {{ $m->Unid_medida }}
            </td>

            <td style="padding:16px;">
                @if($m->Cantidad > 10)
                    <span style="background:#16a34a;color:white;padding:6px 12px;border-radius:20px;font-size:12px;">
                        Bueno
                    </span>
                @elseif($m->Cantidad > 0)
                    <span style="background:#f59e0b;color:white;padding:6px 12px;border-radius:20px;font-size:12px;">
                        Bajo
                    </span>
                @else
                    <span style="background:#dc2626;color:white;padding:6px 12px;border-radius:20px;font-size:12px;">
                        Agotado
                    </span>
                @endif
            </td>

            <td style="padding:16px; border-radius:0 12px 12px 0; white-space:nowrap;">

                <button class="btn btn-primary btn-sm"
                    style="border-radius:8px;"
                    onclick="openEditForm(
                        '{{ $m->Id_material }}',
                        '{{ $m->Descripcion }}',
                        '{{ $m->Cantidad }}',
                        '{{ $m->Unid_medida }}'
                    )">
                    ✏️
                </button>

                <form action="{{ route('material.destroy', $m->Id_material) }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                        style="border-radius:8px;">
                        🗑️
                    </button>
                </form>

            </td>

        </tr>
        @endforeach

    </tbody>
</table>

</div>
            </div>
        </div>

        {{-- FORM CREAR --}}
        <div id="formMaterial" style="display:none; margin-top:15px;">
            <div style="background:#fff; padding:20px; border-radius:12px; position:relative;">

                <button onclick="closeMaterialForm()" style="
                    position:absolute;
                    top:10px;
                    right:10px;
                    border:none;
                    background:#b91c1c;
                    color:white;
                    width:35px;
                    height:35px;
                    border-radius:50%;
                ">✕</button>

                <h4>📦 Nuevo Material</h4>

                <form method="POST" action="{{ route('material.store') }}">
                    @csrf
                    <input type="text" name="descripcion" class="form-control mb-2" placeholder="Descripción">
                    <input type="number" name="cantidad" class="form-control mb-2" placeholder="Cantidad">
                    <input type="text" name="unidad" class="form-control mb-2" placeholder="Unidad">

                    <button class="btn btn-danger w-100">Guardar</button>
                </form>

            </div>
        </div>

        {{-- FORM EDITAR --}}
        <div id="editMaterial" style="display:none; margin-top:15px;">
            <div style="background:#fff; padding:20px; border-radius:12px; position:relative;">

                <button onclick="closeEditForm()" style="
                    position:absolute;
                    top:10px;
                    right:10px;
                    border:none;
                    background:#111;
                    color:white;
                    width:35px;
                    height:35px;
                    border-radius:50%;
                ">✕</button>

                <h4>✏️ Editar Material</h4>

                <form method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <input type="text" name="descripcion" id="edit_desc" class="form-control mb-2">
                    <input type="number" name="cantidad" id="edit_cant" class="form-control mb-2">
                    <input type="text" name="unidad" id="edit_uni" class="form-control mb-2">

                    <button class="btn btn-primary w-100">Actualizar</button>
                </form>

            </div>
        </div>

    </div>

    {{-- ================= PROVEEDORES ================= --}}
    <div id="proveedores" class="tab mt-4" style="display:none;">
        <h4 style="color:#b91c1c;">🚚 Proveedores</h4>

        <div class="row mt-3">
            @forelse($proveedores as $prov)
                <div class="col-md-4 mb-3">
                    <div style="background:#fff; padding:15px; border-radius:12px; border:1px solid #eee;">
                        <h5>{{ $prov->Nombre ?? $prov->nombre ?? 'Proveedor' }}</h5>
                    </div>
                </div>
            @empty
                <p>No hay proveedores registrados.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ESTILOS --}}
<style>
.pill-btn{ border:none; padding:10px 18px; border-radius:30px; font-weight:600; cursor:pointer; }
.red{background:#b91c1c;color:white;}
.green{background:#16a34a;color:white;}
.dark{background:#111827;color:white;}

.badge-ok{background:#dcfce7;color:#166534;padding:4px 10px;border-radius:20px;}
.badge-warn{background:#fef9c3;color:#854d0e;padding:4px 10px;border-radius:20px;}
.badge-bad{background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:20px;}
</style>

<script>
function showTab(tab){
    document.querySelectorAll('.tab').forEach(t => t.style.display='none');
    document.getElementById(tab).style.display='block';
}

function openMaterialForm(){
    document.getElementById('tablaMateriales').style.display='none';
    document.getElementById('formMaterial').style.display='block';
}

function closeMaterialForm(){
    document.getElementById('tablaMateriales').style.display='block';
    document.getElementById('formMaterial').style.display='none';
}

function openEditForm(id, desc, cant, uni){
    document.getElementById('editMaterial').style.display='block';
    document.getElementById('tablaMateriales').style.display='none';

    document.getElementById('edit_desc').value = desc;
    document.getElementById('edit_cant').value = cant;
    document.getElementById('edit_uni').value = uni;

    document.getElementById('editForm').action = '/material/' + id;
}

function closeEditForm(){
    document.getElementById('editMaterial').style.display='none';
    document.getElementById('tablaMateriales').style.display='block';
}
</script>

@endsection