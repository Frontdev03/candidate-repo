<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private $apiUrl = 'https://candidate-testing.api.royal-apps.io/api/v2/authors/';

    public function index()
    {
        $bearerToken = Auth::user()->token_key;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken,
        ])->get($this->apiUrl . '?orderBy=id&direction=ASC&limit=12&page=1');

        $authorsData = $response->json();

        if ($response->successful()) {
            return view('dashboard', compact('authorsData'));
        }
    }

    public function show($id)
    {
        $bearerToken = Auth::user()->token_key;

        $response = Http::withToken($bearerToken)->get($this->apiUrl . $id);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Author not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $bearerToken = Auth::user()->token_key;

        $response = Http::withToken($bearerToken)->put($this->apiUrl . $id, $request->all());

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Failed to update author'], 400);
    }

    public function destroy($id)
    {
        $bearerToken = Auth::user()->token_key;

        $response = Http::withToken($bearerToken)->delete($this->apiUrl . $id);

        if ($response->successful()) {
            return response()->json(['message' => 'Author deleted successfully']);
        }

        return response()->json(['message' => 'Failed to delete author'], 400);
    }

    public function deleteBooks(Request $request)
    {
        $bearerToken = Auth::user()->token_key;

        $response = Http::withToken($bearerToken)->delete('https://candidate-testing.api.royal-apps.io/api/v2/books/' . $request->bookID);

        if ($response->successful()) {
            return response()->json(['message' => 'Book deleted successfully']);
        }

        return response()->json(['message' => 'Failed to delete author'], 400);
    }

    public function books(){
        $bearerToken = Auth::user()->token_key;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken,
        ])->get('https://candidate-testing.api.royal-apps.io/api/v2/books?orderBy=id&direction=ASC&limit=12&page=1');

        $books = $response->json();

        if ($response->successful()) {
            return view('Book.books',compact('books','bearerToken'));
        }
    }

}
