<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;
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
        $technologies = Technology::all(); // recupera tutte le tecnologie
        return view('admin.projects.create', compact('types', 'technologies'));
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
            'technologies' => 'nullable|array',  // Valida che 'technologies' sia un array
            'technologies.*' => 'exists:technologies,id'  // Ogni elemento dell'array deve esistere nella tabella technologies
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

        // Sincronizza le tecnologie
        if (isset($validated['technologies'])) {
            $project->technologies()->sync($validated['technologies']);
        }

        return redirect()->route('projects.index')->with('success', 'Progetto creato con successo!');
    }

    public function show(Project $project)
    {
        // Carica anche le tecnologie associate al progetto
        $project->load('technologies');
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $types = Type::all(); // Recupera tutte le tipologie
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    public function update(Request $request, Project $project)
    {
        // Validazione dei dati in ingresso
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_id' => 'nullable|exists:types,id', // Validazione per il campo type_id
            'technologies' => 'nullable|array',  // Valida che 'technologies' sia un array
            'technologies.*' => 'exists:technologies,id'  // Ogni elemento dell'array deve esistere nella tabella technologies
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

         // Aggiorna le tecnologie associate al progetto
        if (isset($validated['technologies'])) {
            $project->technologies()->sync($validated['technologies']);
        } else {
            // Se nessuna tecnologia è selezionata, disassocia tutte le tecnologie
            $project->technologies()->detach();
        }   

        // Salva le modifiche
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato con successo!');
    }

    public function destroy(Project $project)
    {
        // Disassocia tutte le tecnologie prima di eliminare il progetto
        $project->technologies()->detach();

        // Elimina il progetto
        $project->delete();

        if ($project->image) {
            Storage::delete($project->image);
        }        

        return redirect()->route('projects.index')->with('success', 'Progetto eliminato con successo!');
    }
}

