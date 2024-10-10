<?php
namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display data
    public function index()
    {
        $students = Student::all();
        return view('index', compact('students'));
    }

    // Add student
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
        ]);

        Student::create($request->all());

        return response()->json(['success' => 'Student added successfully!']);
    }

    // Updte data
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:15',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return response()->json(['success' => 'Student updated successfully!']);
    }

    // get by (id)
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    // delete by (id)
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }

}
