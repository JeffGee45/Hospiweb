<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Télécharger un fichier
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'directory' => 'required|string',
        ]);

        try {
            $file = $request->file('file');
            $directory = $request->input('directory', 'uploads');
            $filename = Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs(
                $directory, $filename, 'public'
            );

            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::url($path),
                'original_name' => $file->getClientOriginalName(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement du fichier: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprimer un fichier
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        try {
            if (Storage::disk('public')->exists($request->path)) {
                Storage::disk('public')->delete($request->path);
                return response()->json([
                    'success' => true,
                    'message' => 'Fichier supprimé avec succès',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Fichier non trouvé',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du fichier: ' . $e->getMessage(),
            ], 500);
        }
    }
}
