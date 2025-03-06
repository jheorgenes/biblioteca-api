<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    public function getAll()
    {
        return Book::with('genre')->get();
    }

    public function create(array $data)
    {
        // Forçar status como 'Disponível' independente do que for enviado
        $data['status'] = 'Disponível';
        return Book::create($data);
    }

    public function findById($id)
    {
        return Book::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $book = Book::findOrFail($id);

        // Removendo status dos dados recebidos para impedir alteração indevida de status
        unset($data['status']);

        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        if ($book->status === 'Emprestado') {
            throw new \Exception('Livro emprestado não pode ser excluído.');
        }
        return $book->delete();
    }
}
