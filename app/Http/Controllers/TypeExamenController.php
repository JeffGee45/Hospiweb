<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeExamenResource;
use App\Models\TypeExamen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TypeExamenController extends Controller
{
    /**
     * Affiche la liste des types d'examens avec pagination
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = TypeExamen::query()->with('parametres');
        
        // Filtrage par terme de recherche
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filtrage par catégorie
        if ($categorie = $request->input('categorie')) {
            $query->where('categorie', $categorie);
        }
        
        // Tri
        $sortField = $request->input('sort_field', 'nom');
        $sortDirection = $request->input('sort_direction', 'asc');
        
        if (!in_array($sortField, ['nom', 'code', 'categorie', 'prix', 'created_at'])) {
            $sortField = 'nom';
        }
        
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }
        
        $typeExamens = $query->orderBy($sortField, $sortDirection)
                            ->paginate($request->input('per_page', 15));
        
        return TypeExamenResource::collection($typeExamens);
    }

    /**
     * Enregistre un nouveau type d'examen
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:20|unique:type_examens,code',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'required|string|max:100',
            'prix' => 'required|numeric|min:0',
            'duree_moyenne' => 'required|integer|min:1',
            'preparation_requise' => 'nullable|string',
            'est_actif' => 'boolean',
            'parametres' => 'nullable|array',
            'parametres.*.code' => 'required_with:parametres|string|max:20',
            'parametres.*.nom' => 'required_with:parametres|string|max:255',
            'parametres.*.unite_mesure' => 'nullable|string|max:20',
            'parametres.*.valeur_normale_min' => 'nullable|numeric',
            'parametres.*.valeur_normale_max' => 'nullable|numeric',
            'parametres.*.description' => 'nullable|string',
            'parametres.*.est_actif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        return DB::transaction(function () use ($request) {
            $typeExamen = TypeExamen::create([
                'code' => $request->code,
                'nom' => $request->nom,
                'description' => $request->description,
                'categorie' => $request->categorie,
                'prix' => $request->prix,
                'duree_moyenne' => $request->duree_moyenne,
                'preparation_requise' => $request->preparation_requise,
                'est_actif' => $request->boolean('est_actif', true),
            ]);

            // Ajout des paramètres d'examen si fournis
            if ($request->has('parametres')) {
                $parametres = collect($request->parametres)->map(function ($param) {
                    return [
                        'code' => $param['code'],
                        'nom' => $param['nom'],
                        'unite_mesure' => $param['unite_mesure'] ?? null,
                        'valeur_normale_min' => $param['valeur_normale_min'] ?? null,
                        'valeur_normale_max' => $param['valeur_normale_max'] ?? null,
                        'description' => $param['description'] ?? null,
                        'est_actif' => $param['est_actif'] ?? true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray();

                $typeExamen->parametres()->createMany($parametres);
            }

            return new TypeExamenResource($typeExamen->load('parametres'));
        });
    }

    /**
     * Affiche les détails d'un type d'examen
     *
     * @param TypeExamen $typeExamen
     * @return TypeExamenResource
     */
    public function show(TypeExamen $typeExamen)
    {
        return new TypeExamenResource($typeExamen->load('parametres'));
    }

    /**
     * Met à jour un type d'examen existant
     *
     * @param Request $request
     * @param TypeExamen $typeExamen
     * @return JsonResponse
     */
    public function update(Request $request, TypeExamen $typeExamen)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:20|unique:type_examens,code,' . $typeExamen->id,
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'required|string|max:100',
            'prix' => 'required|numeric|min:0',
            'duree_moyenne' => 'required|integer|min:1',
            'preparation_requise' => 'nullable|string',
            'est_actif' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $typeExamen->update([
            'code' => $request->code,
            'nom' => $request->nom,
            'description' => $request->description,
            'categorie' => $request->categorie,
            'prix' => $request->prix,
            'duree_moyenne' => $request->duree_moyenne,
            'preparation_requise' => $request->preparation_requise,
            'est_actif' => $request->boolean('est_actif', $typeExamen->est_actif),
        ]);

        return new TypeExamenResource($typeExamen->load('parametres'));
    }

    /**
     * Supprime un type d'examen
     *
     * @param TypeExamen $typeExamen
     * @return JsonResponse
     */
    public function destroy(TypeExamen $typeExamen)
    {
        // Vérifier s'il y a des examens médicaux liés
        if ($typeExamen->examens()->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer ce type d\'examen car il est utilisé par des examens médicaux.'
            ], 422);
        }

        // Supprimer les paramètres associés
        $typeExamen->parametres()->delete();
        
        // Supprimer le type d'examen
        $typeExamen->delete();

        return response()->json([
            'message' => 'Type d\'examen supprimé avec succès.'
        ]);
    }
    
    /**
     * Liste des catégories uniques pour les filtres
     * 
     * @return JsonResponse
     */
    public function categories()
    {
        $categories = TypeExamen::select('categorie')
            ->distinct()
            ->orderBy('categorie')
            ->pluck('categorie');
            
        return response()->json($categories);
    }
}
