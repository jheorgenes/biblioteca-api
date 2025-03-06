<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoanService
{
    public function getAll()
    {
        return Loan::with(['user', 'book'])->get();
    }

    public function create(array $data)
    {
        // Buscar emprestimos pendentes para esse livro
        $book = Loan::where('book_id', $data['book_id'])->where('status', 'Pendente')->first();
        if ($book) {
            throw new Exception('Este livro já está emprestado e não pode ser emprestado novamente.');
        }

        $loan = Loan::create($data);

        // Ao criar um emprestimo, atualiza o status do livro para Emprestado
        $loan->book->update(['status' => 'Emprestado']);

        return $loan;
    }

    public function findById($id)
    {
        return Loan::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $loan = $this->findById($id);

        // Garantir que o status não será alterado no update
        unset($data['status']);
        $loan->update($data);
        return $loan;
    }

    public function delete($id)
    {
        return Loan::destroy($id);
    }

    public function updateStatus($id, string $status)
    {
        if (!in_array($status, ['Atrasado', 'Devolvido'])) {
            throw new Exception('Status inválido. Use "Atrasado" ou "Devolvido".');
        }

        $loan = $this->findById($id);
        $loan->update(['status' => $status]);

        //Se o status do emprestimo for Devolvido, atualiza o status do livro para Disponível
        if ($status === 'Devolvido') {
            $loan->book->update(['status' => 'Disponível']);
        }

        return $loan;
    }
}
