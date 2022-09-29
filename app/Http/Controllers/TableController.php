<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\Table;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TableController extends Controller
{
    public function index(Request $request, App $app)
    {
        $app->load('tables.fields');

        foreach ($app->tables as $table)
            $table->field_count = $table->fields->count();

        return Inertia::render('Apps/Tables', [
            'app' => $app,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request, App $app)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['app'] = $app->id;
        $app->tables()->create($validated);

        return redirect(route('tables.index', $app->slug));
    }

    public function show(Field $field)
    {
        $field->load('table.app');
        dd($field);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, App $app, Table $table)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $table->update($validated);
    }

    public function destroy(Request $request, App $app, Table $table)
    {
        // $this->authorize('delete', $app);

        $table->delete();

        return redirect(
            route('tables.index', ['app' => $app->slug])
        );
    }
}
