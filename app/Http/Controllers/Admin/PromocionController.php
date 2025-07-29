<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use App\Models\Producto;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PromocionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promocion::query();

        // Búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%{$search}%");
        }

        // Filtro por estado
        if ($request->has('estado')) {
            $query->where('activa', $request->estado);
        }

        // Filtro por tipo
        if ($request->has('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $promociones = $query->latest()->paginate(10);

        return view('admin.promociones.index', compact('promociones'));
    }

    public function create()
    {
        $productos = Producto::where('disponible', true)->get();
        $ingredientes = Ingrediente::where('disponible', true)->get();
        $diasSemana = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        
        return view('admin.promociones.create', compact('productos', 'ingredientes', 'diasSemana'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Procesar combo_detalle si es tipo combo
        if ($validated['tipo'] === 'combo') {
            $validated['combo_detalle'] = $this->processComboDetalle($request);
        }

        // Procesar días aplicables
        if ($request->has('dias_aplicables')) {
            $validated['dias_aplicables'] = json_encode($request->dias_aplicables);
        }

        Promocion::create($validated);

        return redirect()->route('admin.promociones.index')
                        ->with('success', 'Promoción creada exitosamente');
    }

    public function show(Promocion $promocion)
    {
        return view('admin.promociones.show', ['promocion' => $promocion, 'productos' => Producto::all(),'ingredientes' => Ingrediente::all(),]);
    }

    public function edit(Promocion $promocion)
    {
        $productos = Producto::where('disponible', true)->get();
        $ingredientes = Ingrediente::where('disponible', true)->get();
        $diasSemana = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        $diasSeleccionados = $promocion->dias_aplicables ? json_decode($promocion->dias_aplicables) : [];
        
        return view('admin.promociones.edit', compact(
            'promocion', 
            'productos', 
            'ingredientes',
            'diasSemana',
            'diasSeleccionados'
        ));
    }

    public function update(Request $request, Promocion $promocion)
    {
        $validated = $this->validateRequest($request, $promocion);

        // Procesar combo_detalle si es tipo combo
        if ($validated['tipo'] === 'combo') {
            $validated['combo_detalle'] = $this->processComboDetalle($request);
        } else {
            $validated['combo_detalle'] = null;
        }

        // Procesar días aplicables
        if ($request->has('dias_aplicables')) {
            $validated['dias_aplicables'] = json_encode($request->dias_aplicables);
        } else {
            $validated['dias_aplicables'] = null;
        }

        $promocion->update($validated);

        return redirect()->route('admin.promociones.index')
                        ->with('success', 'Promoción actualizada correctamente');
    }

    public function destroy(Promocion $promocion)
    {
        $promocion->delete();
        return redirect()->route('admin.promociones.index')
                        ->with('success', 'Promoción eliminada correctamente');
    }

    protected function validateRequest(Request $request, $promocion = null)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:2x1,combo,happy_hour,primera_compra,cumpleaños',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'activa' => 'boolean',
        ];

        if ($request->tipo === 'combo') {
            $rules['combo_items'] = 'required|array|min:1';
            $rules['precio_combo'] = 'required|numeric|min:0';
        } else {
            $rules['descuento_porcentaje'] = 'nullable|numeric|between:0,100';
        }

        if ($promocion) {
            $rules['nombre'] .= '|unique:promociones,nombre,'.$promocion->id;
        } else {
            $rules['nombre'] .= '|unique:promociones,nombre';
        }

        return $request->validate($rules);
    }

    protected function processComboDetalle(Request $request)
    {
        $comboItems = [];
        
        foreach ($request->combo_items as $item) {
            $parts = explode('_', $item['id']);
            $tipo = $parts[0];
            $id = $parts[1];
            
            $comboItems[] = [
                'tipo' => $tipo,
                'id' => (int)$id,
                'cantidad' => (int)$item['cantidad']
            ];
        }

        return json_encode([
            'items' => $comboItems,
            'precio_combo' => (float)$request->precio_combo
        ]);
    }
}