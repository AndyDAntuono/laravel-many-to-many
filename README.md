/*CONSEGNA*/

nome repo: laravel-many-to-many

Ciao ragazzi,
continuiamo a lavorare sul codice dei giorni scorsi, ma in una nuova repo e aggiungiamo una nuova entità *Technology*. Questa entità rappresenta le tecnologie utilizzate ed è in relazione *many to many* con i progetti.
I task da svolgere sono diversi, ma alcuni di essi sono un ripasso di ciò che abbiamo fatto nelle lezioni dei giorni scorsi:
- creare la migration per la tabella technologies
- creare il model Technology
- creare la migration per la tabella pivot project_technology
- aggiungere ai model Technology e Project i metodi per definire la relazione many to many
- visualizzare nella pagina di dettaglio di un progetto le tecnologie utilizzate, se presenti
- permettere all’utente di associare le tecnologie nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tecnologie con opportune regole di validazione
Bonus 1:
creare il seeder per il model Technology.
Bonus 2:
aggiungere le operazioni CRUD per il model Technology, in modo da gestire le tecnologie utilizzate nei progetti direttamente dal pannello di amministrazione.

/*SOLUZIONE*/

NB: come ho aperto il collegamento da VSC al browser per avere l'output visivo, mi sono imbattutto in un errore. Ma mi è bastato inserire la parola "admin" nelle rotte delle views. Parte della soluzione al problema spetta al tutor Alessio Crea: vederdì 11-10-24 alle ore 17:45, avevamo intrapreso la strada giusto per risolvere il problema ma a causa della mancanza di tempo non siamo riusciti ad arrivare fino in fondo.
- inizio la soluzione della repo lanciando il comando php artisan make:migration create_technologies_table che crea l'omonima tabella.
    - modifico 2024_10_12_175108_create_technologies_table.php secono le mie necessità.
    - lancio il comando php artisan migrate
    - in phpMyAdmin eseguo il SQL SHOW TABLES; per assicurarmi che la tabella è stata effetivamente creata nel database.
- lancio il comando php artisan make:model Technology per creare l'omonimo modello.
    - modifico il modello Technology.
    - controllo su phpMyAdmin se il modello funzioni correttamente.
- lancio il comando php artisan make:migration create_project_technology_table per creare una tabella pivot.
    - modifico 2024_10_12_190121_create_project_technology_table.php
    - lancio il comando php artisan migrate
    -  controllo su phpMyAdmin se ci siano le colonne id, project_id, technology_id, created_at, e updated_at nella tabella.
- modifico ulteriomente il modello Technology e il modello Project per stabile le relazioni
- effettuo dei controlli per verificare che le modfifiche ai modelli Tecnology e Project funzionino correttamente (anche tramite web.php).
- modifico il flle show.blade.php (Projects) per visulizzare le tecnologie. Se non sono state aggiunte, nella view deve comparire il messaggio "Questo progetto non utilizza nessuna tecnologia."
- sempre nel ProjectController aggiungo le tecnologie nelle pagine di creazione e modifica di un progetto tipo.
- modifico le view di create.blade.php e ed edith.blade.php per aggiungere la possibilità di selezionare la tecnologia durante la creazione di un nuovo progetto o la modifica di uno esistente.
- per rafforzare quanto fatto nel punto precedente implementp la logica di salvataggio e validazione nel ProjectController.php.
- avendo riscontrato degli errori in fase di creazione di un nuovo progetto e di modifica di uno già esistete a causa dell'unicità dello slug, miglioro tutto il codice di ProjectController.

/*ESECUZIONE BONUS 1*/
- lancio il comando php artisan make:seeder TechnologySeeder per creare l'omonimo seeder.
- modifico TechnologySeeder sencondo le mie necessità.
- eseguio il seeder tramite il comando php artisan db:seed --class=TechnologySeeder.

/*ESECUZIONE BONUS 2*/
- lancio il comando php artisan make:controller Admin/TechnologyController --resource per creare un controller che si occupi dei metodi CRUD relativi al modello Technologies.
- modifico TechnologyController secondo le mi necessità.
- Prima di passare alle view di TechniologyController.php devo modificare ProjectController.php, create.blade.php, edit.blade.php e create.blade.php riguadanti le view del modello Projects.
- nel punto precedente mi ero dimenticato di aggiunggere al web.php la rotta per il TechnologyController.php.
- creo la cartella technologies per le view del TechnologyController.
    - creo il file index.blade.php;
    - creo il file create.blade.php;
    - creo il file edit.blade.php
- Purtroppo mi sono imbattuto in un errore che non riesco a risolvere da solo. Usando il tinker mi esce il seguente errore: 
    App\Models\Technology::create(['name' => 'test tecnologia', 'slug' => 'test tecnologia']);

   Illuminate\Database\QueryException  SQLSTATE[HY000]: General error: 1364 Field 'name' doesn't have a default value (SQL: insert into `technologies` (`updated_at`, `created_at`) values (2024-10-13 23:36:17, 2024-10-13 23:36:17)).

   Oltretutto non riesco a vedere l'elenco ne delle tecnologie ne quelle delle tipologie, anche li ho scritte negli appositi seeder.
- Sono riuscito a risolvere la maggior parte degli errori, sopratutto per merito del tutor Alessio Crea che mi ha guidato nella risoluzione.
- decido di aggiornare l'index.blade.php di technology inserendo una modale per la cancellazione di una tecnologia.
- decido di ripetere il passaggio precedente ma con l'index delle tipologie.