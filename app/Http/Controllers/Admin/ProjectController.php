<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index()
    {
        // Ottieni l'utente autenticato
        $user = Auth::user();
        
        // Log per verificare l'ID utente e se è un amministratore
        Log::info('ID utente autenticato: ' . $user->id);
        Log::info('Is user admin? ' . ($user->is_admin ? 'Sì' : 'No'));
        
        // Verifica se l'utente è amministratore
        if ($user && $user->is_admin) {
            // Se l'utente è un amministratore, carica la lista dei progetti
            $projects = Project::all();
            return view('admin.projects.index', compact('projects'));
        } else {
            // Se l'utente non è amministratore, reindirizza alla dashboard con un messaggio di errore
            return redirect()->route('dashboard')->with('error', 'Accesso negato.');
        }
    }

    public function create()
    {
        $types = Type::all(); // recupera tutte le tipologie
        return view('admin.projects.create', compact('types'));
    }

    private function generateUniqueSlug($title, Project $project = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        if ($project) {
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            while (Project::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        return $slug;
    }

    public function store(Request $request)
    {
        // Validazione dei dati in ingresso
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_id' => 'nullable|exists:types,id', // Validazione per il campo type_id
        ]);

        // Gestione dell'immagine se presente
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
        } else {
            $imagePath = null;
        }

        // Creazione del nuovo progetto
        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'image' => $imagePath,
            'type_id' => $validated['type_id'], // Associa la tipologia
        ]);

        return redirect()->route('projects.index')->with('success', 'Progetto creato con successo!');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $types = Type::all(); // Recupera tutte le tipologie
        return view('admin.projects.edit', compact('project', 'types'));
    }

    public function update(Request $request, Project $project)
    {
        // Validazione dei dati in ingresso
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_id' => 'nullable|exists:types,id', // Validazione per il campo type_id
        ]);

        // Gestione dell'immagine se presente
        if ($request->hasFile('image')) {
            // Elimina la vecchia immagine se esiste
            if ($project->image) {
                Storage::delete($project->image);
            }

            // Salva la nuova immagine
            $imagePath = $request->file('image')->store('public/images');
            $project->image = $imagePath;
        }

        // Aggiorna gli altri campi
        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->slug = $this->generateUniqueSlug($validated['title']);
        $project->type_id = $validated['type_id']; // Aggiorna la tipologia

        // Salva le modifiche
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato con successo!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Progetto eliminato con successo!');
    }
}

