<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\Table;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldController extends Controller
{
    public function index(App $app, Table $table)
    {
        $table->load('fields');
        $app->load('user:id,name');

        return Inertia::render('Apps/Fields', [
            'table' => $table,
            'app' => $app,
            'types' => Field::$types,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request, App $app, Table $table)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255'
        ]);

        $validated['table'] = $table->id;
        $table->fields()->create($validated);

        return redirect(route('fields.index', ['app' => $app->slug, 'table' => $table->slug]));
    }

    public function show(Field $field)
    {
        //
    }

    public function edit(Field $field)
    {
        //
    }

    public function update(Request $request, App $app, Table $table, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255'
        ]);

        $field->update($validated);

    }

    public function destroy(Field $field)
    {
        //
    }
}
