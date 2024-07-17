<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    // POST /api/class
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'size' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $class = ClassModel::create($request->all());
        return response()->json($class, 201);
    }

    // GET /api/class
    public function index()
    {
        $classes = ClassModel::all();
        dd($classes);
        return response()->json($classes);
    }

    // GET /api/class/page/{page}
    public function paginate($page = 1)
    {
        $perPage = 10;
        $classes = ClassModel::paginate($perPage, ['*'], 'page', $page);
        return response()->json($classes);
    }

    // GET /api/class/{id}
    public function show($id)
    {
        $class = ClassModel::findOrFail($id);
        return response()->json($class);
    }

    // PUT /api/class/{id}
    public function update(Request $request, $id)
    {
        $class = ClassModel::findOrFail($id);
        $class->update($request->all());
        return response()->json($class);
    }

    // DELETE /api/class/{id}
    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();
        return response()->json(null, 204);
    }

    // POST /api/class/copy/{id}
    public function copy($id)
    {
        $class = ClassModel::findOrFail($id);
        $newClass = $class->replicate();
        $newClass->name = $newClass->name . ' (Copy)';
        $newClass->save();
        return response()->json($newClass, 201);
    }

    // POST /api/class/copy
    public function copyMultiple(Request $request)
    {
        $ids = $request->input('ids');
        $newClasses = [];
        foreach ($ids as $id) {
            $class = ClassModel::findOrFail($id);
            $newClass = $class->replicate();
            $newClass->name = $newClass->name . ' (Copy)';
            $newClass->save();
            $newClasses[] = $newClass;
        }
        return response()->json($newClasses, 201);
    }

    // POST /api/class/import
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:json',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $file = $request->file('file');
        $data = json_decode(file_get_contents($file), true);

        $classes = [];
        foreach ($data as $item) {
            $classes[] = ClassModel::create($item);
        }

        return response()->json($classes, 201);
    }

    // GET /api/class/export
    public function export()
    {
        $classes = ClassModel::all();
        $filename = 'classes_' . date('Y-m-d') . '.json';
        return response()->json($classes)
            ->header('Content-Disposition', 'attachment; filename=' . $filename);
    }
}