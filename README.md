/*CONSEGNA*/

nome repo: laravel-one-to-many
Ciao ragazzi,
continuiamo a lavorare sul codice dei giorni scorsi, ma in una nuova repo e aggiungiamo una nuova entità Type. Per realizzare la repo nuova a partire da quella vecchia avete due modi: repo template oppure copiate la cartella.
Repo template: rendete la repo laravel-auth momentaneamente una repo template, createne una nuova chiamata laravel-one-to-many a partire da questa, clonatela in locale e quindi rendete laravel-auth nuovamente una repo normale.
Copiare la cartella: copiate la cartella laravel-auth. Rinominatela in laravel-one-to-many. Entrate dentro questa nuova cartella e cancellate la cartella nascosta .git.
L'entità Type rappresenta la tipologia di progetto ed è in relazione one to many con i progetti.
I task da svolgere sono diversi, ma alcuni di essi sono un ripasso di ciò che abbiamo fatto nelle lezioni dei giorni scorsi:
- creare la migration per la tabella types
- creare il model Type
- creare la migration di modifica per la tabella projects per aggiungere la chiave esterna
- aggiungere ai model Type e Project i metodi per definire la relazione one to many
- visualizzare nella pagina di dettaglio di un progetto la tipologia associata, se presente
- permettere all’utente di associare una tipologia nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tipologia con opportune regole di validazione
Bonus 1:
creare il seeder per il model Type.
Bonus 2:
aggiungere le operazioni CRUD per il model Type, in modo da gestire le tipologie di progetto direttamente dal pannello di amministrazione.

/*CONSEGNA*/

NB: dal momento che ieri non mi sono sentito bene, inizio questa repo oggi 10-10-24.
- creo la repo attraverso il metodo della template
- creo un nuovo database, intitolato laravel-one-to-many.
- modifico il nome del DB_DATABASE da laravel in laravel-one-to-many 
- lancio i comandi php artisan serve e npm run dev
- lancio il comando php artisan migrate:refresh --seed per rilanciare migrazione e seeder
- lancio il comando php atisan storage:link
- lancio il comando php artisan make:migration create_types_table per aggiiugere la colonna types alla tabella projects
- modifico il file 2024_10_10_151521_create_types_table.php
- lancio il comando php artisan make:migration add_type_id_to_projects_table --table=projects per aggiungere la colonna types alla tabella projects.
- modifico 2024_10_10_151042_add_type_id_to_projects_table.php
- lancio il comando php artisan make:model Type per creare l'omonimo modello
- modifico il modello Type secondo le mie necessità.
- decido di creare uno show.blade.php per visulizzare i dettagli di un progetto, come titolo, descrizione, immagine e adesso anche la tipologia.
- modifico il codice di index.blade.php per includere il collegamento a show.blade.php
- modifico ProjectController per includere la gestione delle associazioni tra progetti e tipologie.
- modifico create.blade.php per includere un dropdow, o menù a tendina, nella form così l'utente possa scegliere la tipologia del progetto.
- ripeto il passaggio successivo ma stavolta per il file edit.blade.php.
- dato che sono un ciuco non avevo effettuato php artisan migrate dopo aver creato le tabelle types e quella per la id.
    - ma dal momento che avevo creato prima la tabella dell'id e DOPO quella di Types, la migrazione non poteve di certo avvenire correttamente!
    - ergo ho rinominato la migrazione della tabella types da 2024_10_10-151521 a 2024_10_100000 per riparare a questo "paradosso temporale"
    - ma avendo creato precedemente la tabella id riscontravo comunque degli errori. Ho quindi moficato 2024_10_10_151042_add_type_id_to_projects_table come segue:
        public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'type_id')) {
                $table->unsignedBigInteger('type_id')->nullable(); // Aggiunge la colonna solo se non esiste
            }
        
            // Crea la chiave esterna solo se la colonna è stata aggiunta
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
        });
    }
- dato che sono un ciuco, mi sono dimenticato di popolare la tabella Types e ciò significa che non appare nessuna opzione nel menù a tendina. Ergo apporto le dovute modifiche.
- ho dovuto apportate diverse correzioni poiché riscontravo vari errori nel controolo delle view e nella scelta di tipologia di progetto.
- modifico ulteriormente il modello Type.php e TypeSeeder.php soddisfare il completamento del Bonus 1.
- Eseguo il comando php artisan make:controller Admin/TypeController --resource per un controller con i metodi base per le operazioni CRUD.
- modifico il file web.php per aggiungingere le rotte per il CRUD di TypeController.php.
- creo la sotto-cartella types nella cartella admin (che asua volta si trova nella cartella views) e creo il file index.blade.php 
    - modifico il codice di index.blade.php secondo le mie necessità.
- sempre nella sotto cartella types creo i file create.index.php e edit.blade.php.
    - modifico il codice di create.blade.php.
    - modifico il codide di edit.blade.php.
- aggiorno il codice di TypeController.php per modificare le CRUD.
- decido di creare un pannello di amministrazione e per questo creo il file admin.blade.php nella sotto-cartella layouts.
    - modifico il file admin.blade.php secondo le mie necessità.
- avendo realizzato di rischiare di combinare un grandissimo casino, cancello admin.blade.php e integro quel che mi serve da esso direttamente in app.blade.php
- dal momento che ho problemi di visualizzazion legati al ruolo di user.php lancio la migrazione php artisan make:migration add_is_admin_to_users_table --table=users per cercare di risolvere il problema.
- sfortunamente non riesco a risolvere il problema di Route [admin.projects.index] not defined.
- Dopo tanti tentativi a vuoto mi sono contretto a cancellare "admin" nelle routes delle view dell'intero progetto. Non è la soluzione ideale ma se non faccio così non ottengo le view.