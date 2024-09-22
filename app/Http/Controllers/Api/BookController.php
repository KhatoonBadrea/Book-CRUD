<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Services\BookService;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{

    use ApiResponseTrait;


    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $book = $this->bookService->getAllBook();
        return ($book->isNotEmpty()) ? $this->successResponse('this is all books', $book, 200) : $this->notFound('there are not any book here');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request)
    {

        $validated = $request->validated();
        $book = $this->bookService->addBook($validated);
        return $this->successResponse('this is all books', $book, 200);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $book = $this->bookService->showBook($id);
        return $this->successResponse('this is all books', $book, 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();
        $book = $this->bookService->updateBook($book, $validated);
        return $this->successResponse('this is all books', $book, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->bookService->deleteBook($id);
            return $this->successResponse('Book deleted successfully.', [], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}
