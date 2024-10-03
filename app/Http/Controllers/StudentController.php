<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        // Adicione o valor para `student_status`
        $validatedData['student_status'] = 0;  // 0=Alterável pelo Estudante
        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if ($student) {return response()->json($student);}
        return response()->json(['message' => 'Student not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);
        // Obtenha todos os dados validados
        $data = $request->validated();
        // Remova o campo 'email' dos dados antes da atualização
        unset($data['email']);
        // Atualize o aluno com os dados filtrados
        $student->update($data);
        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student->delete();
        return response()->json(null, 204);
    }

    /**
     * Controladores para serem acessadas pelos Estudantes
     */

    public function showStudentData(string $id)
    {
        $student = Student::where('user_id', $id)->first();
        if ($student) {return response()->json($student);}
        return response()->json(['message' => 'Student not found.'], 404);
    }

    public function storeDataStudent(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        // Adicione o valor para `student_status`
        $validatedData['student_status'] = 0;  // 0=Alterável pelo Estudante
        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    public function updateStudent(UpdateStudentRequest $request, string $id)
    {
        $student = Student::where('user_id', $id)->first();
        if(!$student){
            return response()->json(["message"=>'Student not Found'], 404);
        }
        // Obtenha todos os dados validados
        $data = $request->validated();
        // Remova o campo 'email' dos dados antes da atualização
        unset($data['email']);
        // Atualize o aluno com os dados filtrados
        $student->update($data);
        return response()->json($student, 200);
    }

}
