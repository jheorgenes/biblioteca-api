<?php

namespace App\Http\Controllers;

use App\Services\GenreService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;

class GenreController extends Controller
{

    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->genreService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:genres',
        ]);

        return response()->json($this->genreService->create($data), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->genreService->findById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gênero não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:genres,name,' . $id,
            ]);

            return response()->json($this->genreService->update($id, $data));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Gênero não encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json(['message' => 'Gênero excluído com sucesso', 'deleted' => $this->genreService->delete($id)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
