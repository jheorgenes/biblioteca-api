<?php

namespace App\Http\Controllers;

use App\Services\LoanService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->loanService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date',
        ]);

        try {
            return response()->json($this->loanService->create($data), 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->loanService->findById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empréstimo não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'book_id' => 'required|exists:books,id',
                'return_date' => 'required|date',
            ]);

            return response()->json($this->loanService->update($id, $data));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empréstimo não encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json(['message' => 'Empréstimo excluído com sucesso', 'deleted' => $this->loanService->delete($id)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'status' => 'required|in:Atrasado,Devolvido',
            ]);

            return response()->json($this->loanService->updateStatus($id, $data['status']));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Empréstimo não encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
