<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\BookResource;
use App\Http\Traits\ApiResponseTrait;


class BookService
{
    use ApiResponseTrait;

    public function getAllBook()
    {
        try {

            $book = Book::all();
            return BookResource::collection($book);
        } catch (\Exception $e) {
            Log::error('Error in Bookervice@getAllBook: ' . $e->getMessage());
            return $this->errorResponse('An error occurred: ' . 'there is an error in the server', 500);
        }
    }

    public function addBook(array $data)
    {
        // dd($data);
        try {

            $book = Book::create([
                'title' => $data['title'],
                'author' => $data['author'],
                'published_at' => $data['published_at'],
                'is_active' => $data['is_active'],
            ]);

            return BookResource::make($book)->toArray(request());
        } catch (\Exception $e) {
            Log::error('Error in Bookervice@addBook: ' . $e->getMessage());
            return $this->errorResponse('An error occurred: ' . 'there is an error in the server', 500);
        }
    }

    public function updateBook(Book $book, array $data)
    {
        try {
            $book->update([
                'title' => $data['title'] ?? $book->title,
                'author' => $data['author'] ?? $book->author,
                'published_at' => $data['published_at'] ?? $book->published_at,
                'is_active' => $data['is_active'] ?? $book->is_active,
            ]);
            return BookResource::make($book)->toArray(request());
        } catch (\Exception $e) {
            Log::error('Error in Bookervice@updateBook: ' . $e->getMessage());
            return $this->errorResponse('An error occurred: ' . 'there is an error in the server', 500);
        }
    }

    public function deleteBook(int $id)
    {
        try {
            $book = Book::find($id);
            if (!$book) {
                throw new \Exception('Book not found.');
            }

            $book->delete();
        } catch (\Exception $e) {
            Log::error('Error in BookController@deleteBook: ' . $e->getMessage());
            throw $e;
        }
    }

    public function showBook(int $id)
    {
        try {
            $book = Book::find($id);
            if (!$book) {
                return $this->notFound('Book Not Found');
            }
            return $book;
        } catch (\Exception $e) {
            Log::error('Error in BookController@deleteBook: ' . $e->getMessage());
            throw $e;
        }
    }
}
