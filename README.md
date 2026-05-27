# FachowiecNaJuz

Platforma łącząca klientów z zaufanymi fachowcami. Przeglądaj profile specjalistów, filtruj według lokalizacji i kategorii, czytaj opinie i wystawiaj własne.

---

## Spis treści

- [FachowiecNaJuz](#fachowiecnajuz)
  - [Spis treści](#spis-treści)
  - [Opis projektu](#opis-projektu)
  - [Funkcjonalności](#funkcjonalności)
    - [Dla użytkownika](#dla-użytkownika)
    - [Dla specjalisty](#dla-specjalisty)
  - [Technologie](#technologie)
  - [Uruchomienie (Docker)](#uruchomienie-docker)
  - [Diagram ERD](#diagram-erd)
  - [Przepływ użytkownika](#przepływ-użytkownika)
  - [API](#api)
  - [Zrzuty ekranu](#zrzuty-ekranu)
    - [Strona główna](#strona-główna)
    - [Dashboard z filtrami](#dashboard-z-filtrami)
    - [Profil specjalisty](#profil-specjalisty)
    - [Formularz opinii](#formularz-opinii)
    - [Kokpit profesjonalisty](#kokpit-profesjonalisty)
    - [Edycja profilu specjalisty](#edycja-profilu-specjalisty)
    - [Responsywność (widok mobilny)](#responsywność-widok-mobilny)
  - [Przyszłe prace](#przyszłe-prace)

---

## Opis projektu

FachowiecNaJuz umożliwia szybkie znalezienie sprawdzonego fachowca w Twojej okolicy. Aplikacja oferuje dwa rodzaje kont:  
- **Użytkownik (User)** – przegląda profile, filtruje ekspertów, wystawia opinie.  
- **Specjalista (Specialist)** – zarządza własnym profilem, kategoriami, lokalizacjami i zdjęciami prac.

---

## Funkcjonalności

### Dla użytkownika
- Rejestracja i logowanie (z szyfrowaniem haseł)
- Przeglądanie fachowców z ich średnią oceną i liczbą recenzji
- Filtrowanie po mieście, kategoriach i minimalnej ocenie
- Szczegółowy widok profilu specjalisty (opis, kategorie, portfolio, opinie)
- Dodawanie opinii wraz z oceną gwiazdkową
- Responsywny design – wygodne przeglądanie na telefonie i komputerze

### Dla specjalisty
- Tworzenie i edycja profilu publicznego
- Zarządzanie kategoriami usług (np. Hydraulika, Elektryka)
- Wybór miast, w których działa
- Dodawanie zdjęć do portfolio
- Podgląd statystyk i opinii w dedykowanym kokpicie

---

## Technologie

| Warstwa   | Technologia                      |
|-----------|----------------------------------|
| Backend   | PHP 8.3 (obiektowo, MVC)        |
| Frontend  | HTML5, CSS3, JavaScript (Vanilla)|
| Baza danych | PostgreSQL 15                  |
| Serwer    | Nginx + PHP-FPM                 |
| Środowisko | Docker + Docker Compose         |

---

## Uruchomienie (Docker)

1. Sklonuj repozytorium:
   ```bash
   git clone https://github.com/twoje-repozytorium.git
   cd AplikacjeInternetowePK

2. Uruchom kontenery:

    ```bash
    docker-compose up -d
    ```
    
    
3. Aplikacja będzie dostępna pod adresem http://localhost:8080.

4. Dane testowe:

- Użytkownik: jan.kowalski@example.com / password123

- Specjalista: adam.kowalski@pro.pl / password123

5. Panel administracyjny bazy danych (pgAdmin):

- URL: http://localhost:5050

- Email: admin@admin.com

- Hasło: admin

Pierwsze uruchomienie może potrwać chwilę – kontener PostgreSQL wykonuje skrypt init.sql tworzący strukturę i dane startowe.

Struktura projektu (MVC)

```text
src/
 ├── controllers/   # Kontrolery (AppController, ApiController, Security...)
 ├── models/        # Modele danych (User, Specialist, Review...)
 ├── repositories/  # Warstwa dostępu do bazy (PDO)
public/
 ├── scripts/       # Pliki JavaScript
 ├── styles/        # Arkusze CSS
 ├── views/         # Szablony HTML
docker/             # Konfiguracja Docker (PHP, Nginx, DB)
```
Przepływ: Widok (HTML/JS) → Kontroler → Repozytorium → Baza danych i z powrotem.

## Diagram ERD

Poniżej znajduje się diagram encji dla bazy danych PostgreSQL.

![Diagram ERD](/screenshots/diagramERD.png)

Opis najważniejszych relacji:

- users 1:1 profiles (każdy użytkownik ma profil)

- users 1:1 specialists (użytkownik z rolą Specialist ma profil specjalisty)

- specialists 1:N reviews (jeden specjalista – wiele opinii)

- specialists 1:N portfolio_items (jeden specjalista – wiele zdjęć)

- specialists M:N categories (przez specialist_categories)

- specialists M:N locations (przez specialist_locations)

## Przepływ użytkownika
1. Strona główna – użytkownik może od razu wyszukać fachowca po kategorii i mieście.

2. Dashboard (Find Experts) – wyniki wyszukiwania, filtrowanie dynamiczne po stronie klienta.

3. Profil eksperta – szczegółowe informacje, galeria prac i opinie. Zalogowany użytkownik może dodać opinię.

4. Kokpit profesjonalisty – po zalogowaniu jako specjalista dostępne są statystyki, lista opinii i szybkie linki do edycji profilu.

5. Ustawienia profilu – edycja danych, kategorii, lokalizacji i portfolio.
   
## API
Aplikacja udostępnia REST API dla wybranych zasobów:


| Metoda | Endpoint | Opis | Wymagana autoryzacja |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/specialists` | Lista specjalistów z ocenami | Nie |
| **GET** | `/api/locations` | Lista dostępnych miast | Nie |
| **POST** | `/api/locations` | Dodanie nowego miasta | Tak (dowolna rola) |
| **POST** | `/api/login` | Logowanie | Nie |
| **POST** | `/api/logout` | Wylogowanie | Nie |



## Zrzuty ekranu
### Strona główna
![Strona główna](/screenshots/home.png)

### Dashboard z filtrami
![Dashboard z filtrami](/screenshots/dashboard.png)

### Profil specjalisty
![Profil specjalisty](/screenshots/expert-details.png)

### Formularz opinii
![Formularz opinii](/screenshots/review.png)

### Kokpit profesjonalisty
![Kokpit profesjonalisty](/screenshots/pro-dashboard.png)

### Edycja profilu specjalisty
![Edycja profilu specjalisty](/screenshots/profile-settings.png)

### Responsywność (widok mobilny)
![Responsywność (widok mobilny)](/screenshots/mobile-view.png)

## Przyszłe prace
- Powiadomienia e‑mail o nowych opiniach

- Panel administratora z moderacją treści

- System wiadomości pomiędzy klientem a fachowcem