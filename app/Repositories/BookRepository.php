<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class BookRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    /**
     * Get All Books.
     *
     * @return collections Array of Book Collection
     */
    public function getAll(): Paginator
    {
        return $this->user->books()
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
    }

    /**
     * Get Paginated Book Data.
     *
     * @param int $pageNo
     * @return collections Array of Book Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Book::orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Book Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Book Collection
     */
    public function searchBook($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Book::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New Book.
     *
     * @param array $data
     * @return object Book Object
     */
    public function create(array $data): Book
    {
        $titleShort      = Str::slug(substr($data['title'], 0, 20));
        $data['user_id'] = $this->user->id;

        if (!empty($data['file'])) {
            $data['file'] = UploadHelper::upload('file', $data['file'], $titleShort . '-' . time(), 'files/books');
        }

        return Book::create($data);
    }

    /**
     * Delete Book.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $book = Book::find($id);
        if (empty($book)) {
            return false;
        }

        UploadHelper::deleteFile('files/books/' . $book->file);
        $book->delete($book);
        return true;
    }

    /**
     * Get Book Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Book|null
    {
        return Book::with('user')->find($id);
    }

    /**
     * Update Book By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Book Object
     */
    public function update(int $id, array $data): Book|null
    {
        $book = Book::find($id);
        if (!empty($data['file'])) {
            $titleShort = Str::slug(substr($data['title'], 0, 20));
            $data['file'] = UploadHelper::update('file', $data['file'], $titleShort . '-' . time(), 'files/books', $book->file);
        } else {
            $data['file'] = $book->file;
        }

        if (is_null($book)) {
            return null;
        }

        // If everything is OK, then update.
        $book->update($data);

        // Finally return the updated book.
        return $this->getByID($book->id);
    }
}
