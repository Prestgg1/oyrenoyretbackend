<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Documentasiyası",
 *      description="Laravel Swagger API Documentasiya",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url= "oyrenoyret.az",
 *      description="Local Server"
 * )
 */

class PostController extends Controller
{

   /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Bütün Postları Getir",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Uğurla Çıxarıldı"
     *     )
     * )
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Tək Bir Postları Getir",
     *    @OA\Parameter(
     *            name="id",
     *            in="path",
     *            description="İd-yi yaz",
     *            required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Uğurla Çıxarıldı"
     *     )
     * )
     */
      
    public function index()
    {

 
        $posts = Post::all();
        return response()->json([
            'status' => true,
            'message' => 'Melumatlar Uğurla Çıxarıldı',
            'data' => $posts
        ], 200);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Customer found successfully',
            'data' => $post
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Post::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Post::findOrFail($id);
        $customer->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully',
            'data' => $customer
        ], 200);
    }

    public function destroy($id)
    {
        $customer = Post::findOrFail($id);
        $customer->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully'
        ], 204);
    }
}
