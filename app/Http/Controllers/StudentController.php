<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // POST /api/student
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
            'hometown' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'phone_number' => 'required|string|max:20',
            'username' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|string',
            'note' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $student = Student::create($data);
        return response()->json($student, 201);
    }

    // GET /api/student
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    // GET /api/student/page/{page}
    public function paginate($page = 1)
    {
        $perPage = 10;
        $students = Student::paginate($perPage, ['*'], 'page', $page);
        return response()->json($students);
    }

    // GET /api/student/{id}
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    // PUT /api/student/{id}
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $data = $request->all();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $student->update($data);
        return response()->json($student);
    }

    // DELETE /api/student/{id}
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(null, 204);
    }

    // POST /api/student/copy/{id}
    public function copy($id)
    {
        $student = Student::findOrFail($id);
        $newStudent = $student->replicate();
        $newStudent->username = $newStudent->username . '_copy';
        $newStudent->email = 'copy_' . $newStudent->email;
        $newStudent->save();
        return response()->json($newStudent, 201);
    }

    // POST /api/student/copy
    public function copyMultiple(Request $request)
    {
        $ids = $request->input('ids');
        $newStudents = [];
        foreach ($ids as $id) {
            $student = Student::findOrFail($id);
            $newStudent = $student->replicate();
            $newStudent->username = $newStudent->username . '_copy';
            $newStudent->email = 'copy_' . $newStudent->email;
            $newStudent->save();
            $newStudents[] = $newStudent;
        }
        return response()->json($newStudents, 201);
    }

    // POST /api/student/import
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

        $students = [];
        foreach ($data as $item) {
            $item['password'] = Hash::make($item['password']);
            $students[] = Student::create($item);
        }

        return response()->json($students, 201);
    }

    // GET /api/student/export
    public function export()
    {
        $students = Student::all();
        $filename = 'students_' . date('Y-m-d') . '.json';
        return response()->json($students)
            ->header('Content-Disposition', 'attachment; filename=' . $filename);
    }
}