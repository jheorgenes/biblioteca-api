<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->bookService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'author' => 'required|string',
            'registration_number' => 'required|unique:books',
            'status' => 'required|in:Emprestado,Disponível',
            'genre_id' => 'required|exists:genres,id'
        ]);

        return response()->json($this->bookService->create($data), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->bookService->findById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'author' => 'required|string',
                'registration_number' => 'required|unique:books,registration_number,' . $id,
                'status' => 'required|in:Emprestado,Disponível',
                'genre_id' => 'required|exists:genres,id'
            ]);

            return response()->json($this->bookService->update($id, $data));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json(['message' => 'Livro excluído com sucesso', 'deleted' => $this->bookService->delete($id)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
