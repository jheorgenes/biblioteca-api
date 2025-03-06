<?php

namespace App\Services;

use App\Models\Genre;
use App\Models\Book;

class GenreService
{
    public function getAll()
    {
        return Genre::all();
    }

    public function create(array $data)
    {
        return Genre::create($data);
    }

    public function findById($id)
    {
        return Genre::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $genre = Genre::findOrFail($id);
        $genre->update($data);
        return $genre;
    }

    public function delete($id)
    {
        $booksLinked = Book::where('genre_id', $id)->pluck('id')->toArray();

        if (!empty($booksLinked)) {
            throw new \Exception('Não é possível excluir este gênero. Ele está vinculado aos seguintes IDs de livros: ' . implode(', ', $booksLinked));
        }

        return Genre::destroy($id);
    }
}
