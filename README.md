# Baza filmów - API

## Funkcjonalność

Baza danych korzysta z modeli User (autoryzacja) oraz Movie (Rest API). Do autoryzacji został wykorzystana funkcjonalność Laravel Sanctum.
System bazodanowy to SQLite, dodatkowo dodano cache oraz testy jednostkowe PHPUnit dla kontrolera MovieController.

## Uruchomienie projektu

Po pobraniu repozytorium należy wykonać następujące komendy:
 1. composer install
 2. cp .env.example .env (w nowym pliku .env ustawiamy DB_CONNECTION=sqlite oraz DB_DATABASE=database.sqlite)
 3. php artisan key:generate
 4. php artisan serve

## Lista endpointów

Endpointy testujemy przy pomocy adresu **127.0.0.1:8000/api**

Kolekcja User
 - /register (POST) - rejestracja użytkownika
 - /login (POST) - logowanie użytkownika
 - /user (GET) - informacje o aktualnie zalogowanym użytkowniku
 
Kolekcja **Movie** która wymaga autoryzacji poprzez Bearer Token.
 - /movies (GET) - listowanie wszystkich filmów w bazie
 - /movies (POST) - dodanie nowego filmu
 - /movies/{movie} (GET) - otrzymanie informacji tylko o jednym filmie
 - /movies/{movie} (PUT) - zmiana informacji dla jednego filmu
 - /movies/{movie} (DELETE) - usunięcie wybranego filmu

Więcej informacji jest zawarta w pliku **api_doc.json**. Można zaimportować go np. do programu Postman.

## Cache

Cache działa w oparciu o bibliotekę **Facades\Cache**. Tworzy się on przy listowaniu wszystkich filmów. Jeżeli została wykonana jakaś modyfikacja w bazie danych przy wykorzystaniu innych endpointów jest on usuwany i przy listowaniu tworzony na nowo.

## Testy jednostkowe

Testy jednostkowe zostały napisane w oparciu o **PHPUnit**. Aby uruchomić testy dla kontrolera MovieController należy użyć  polecenia: **php artisan test --filter MovieControllerTest**