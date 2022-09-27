<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\Table;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Index', [
            'apps' => App::with('user:id,name')->withCount('tables')->latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->apps()->create($validated);

        return redirect(route('apps.index'));
    }

    public function show(Request $request, App $app)
    {
        $request->session()->put('app', $app);

        $app->load('tables', 'user');

        return Inertia::render('Apps/Show', [
            'app' => $app,
        ]);
    }

    public function edit(App $app)
    {
        //
    }

    public function update(Request $request, App $app)
    {
        $this->authorize('update', $app);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $app->update($validated);

        return redirect(route('apps.index'));
    }

    public function destroy(App $app)
    {
        $this->authorize('delete', $app);

        $app->load('tables:id');

        Field::whereIn('table_id', $app->tables->pluck('id'))->delete();
        Table::whereIn('id', $app->tables->pluck('id'))->delete();
        $app->delete();

        return redirect(route('apps.index'));
    }
}
