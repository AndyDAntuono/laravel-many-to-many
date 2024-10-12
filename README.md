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
