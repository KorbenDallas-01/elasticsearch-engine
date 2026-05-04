# Wyszukiwarka zarządzeń — Elasticsearch + PHP

Prosty projekt webowy służący do wyszukiwania dokumentów PDF na podstawie wcześniej zaindeksowanej treści tekstowej. Aplikacja składa się z formularza wyszukiwania w PHP/HTML, endpointu zwracającego wyniki w JSON oraz skryptu Python indeksującego pliki tekstowe do Elasticsearch.

## Funkcje

- wyszukiwanie po treści dokumentu,
- wyszukiwanie po nazwie pliku,
- prezentacja wyników w przeglądarce bez przeładowania strony dzięki AJAX,
- możliwość ograniczenia liczby wyświetlanych wyników,
- indeksowanie wielu plików `.txt` do Elasticsearch,
- mapowanie plików `.txt` na odpowiadające im nazwy plików `.pdf`.

## Technologie

- PHP,
- JavaScript / jQuery,
- HTML i CSS,
- Python,
- Elasticsearch,
- biblioteka PHP `elastic/elasticsearch`,
- biblioteka Python `elasticsearch`.

## Struktura projektu

```text
exportENGINE/
├── app/
│   └── init.php          # Konfiguracja połączenia z Elasticsearch
├── index.php             # Główna strona wyszukiwarki
├── search.php            # Endpoint wykonujący zapytanie do Elasticsearch
├── indexing.py           # Skrypt indeksujący pliki tekstowe
├── style.css             # Style aplikacji
├── db.ico                # Ikona strony
├── logo-ibe.png          # Logo wyświetlane w interfejsie
└── pdf.png               # Ikona pliku PDF
```

## Wymagania

Przed uruchomieniem projektu należy mieć zainstalowane:

- PHP 8.x,
- Composer,
- Python 3.x,
- Elasticsearch uruchomiony lokalnie pod adresem `http://localhost:9200`,
- serwer WWW, np. Apache, Nginx albo wbudowany serwer PHP.

## Instalacja

### 1. Pobranie projektu

Sklonuj repozytorium lub pobierz pliki projektu:

```bash
git clone <adres_repozytorium>
cd exportENGINE
```

### 2. Instalacja zależności PHP

W katalogu projektu zainstaluj klienta Elasticsearch dla PHP:

```bash
composer require elasticsearch/elasticsearch
```

Po instalacji powinien powstać katalog `vendor/`, który jest wymagany przez plik:

```php
require_once 'vendor/autoload.php';
```

### 3. Instalacja zależności Python

Zainstaluj bibliotekę Elasticsearch dla Pythona:

```bash
pip install elasticsearch
```

### 4. Uruchomienie Elasticsearch

Upewnij się, że Elasticsearch działa lokalnie:

```bash
curl http://localhost:9200
```

Aplikacja domyślnie łączy się z Elasticsearch pod adresem:

```text
localhost:9200
```

Konfiguracja znajduje się w pliku:

```text
app/init.php
```

## Indeksowanie dokumentów

Skrypt `indexing.py` odczytuje pliki `.txt` z katalogu:

```text
/home/elastic/text
```

Każdy plik tekstowy jest indeksowany w Elasticsearch jako dokument zawierający:

- `filename` — nazwa pliku PDF powstała przez zamianę rozszerzenia `.txt` na `.pdf`,
- `content` — pełna treść pliku tekstowego.

Domyślna nazwa indeksu to:

```text
data_science
```

Aby uruchomić indeksowanie:

```bash
python indexing.py
```

Po poprawnym zakończeniu działania skrypt wyświetli komunikat:

```text
Files indexed successfully!
```

## Uruchomienie aplikacji

Projekt można uruchomić na serwerze WWW albo lokalnie przy pomocy wbudowanego serwera PHP:

```bash
php -S localhost:8000
```

Następnie otwórz w przeglądarce:

```text
http://localhost:8000
```

## Sposób działania

1. Użytkownik wpisuje frazę w polu wyszukiwania.
2. Formularz w `index.php` wysyła zapytanie AJAX do pliku `search.php`.
3. `search.php` wykonuje zapytanie do Elasticsearch.
4. Elasticsearch szuka dopasowań w polach:
   - `content`,
   - `filename`.
5. Wyniki są zwracane jako JSON.
6. Strona wyświetla listę znalezionych plików PDF.

## Konfiguracja

### Adres Elasticsearch

Adres serwera Elasticsearch można zmienić w pliku `app/init.php`:

```php
$hosts = ['localhost:9200'];
```

### Katalog z plikami tekstowymi

Ścieżkę do katalogu z plikami `.txt` można zmienić w pliku `indexing.py`:

```python
directory_path = "/home/elastic/text"
```

### Nazwa indeksu Elasticsearch

Nazwa indeksu ustawiona jest w pliku `indexing.py`:

```python
"_index": "data_science"
```

## Ważne uwagi

- Pliki `.txt` powinny zawierać treść dokumentów PDF przygotowaną wcześniej np. przez OCR lub konwersję PDF do tekstu.
- Nazwa pliku `.txt` powinna odpowiadać nazwie pliku `.pdf`.
- Przykład: plik `zarzadzenie_1.txt` zostanie zapisany w indeksie jako `zarzadzenie_1.pdf`.
- Pliki PDF powinny znajdować się w katalogu obsługiwanym przez aplikację webową, zgodnie ze ścieżką ustawioną w linkach wyników.
- Katalog `vendor/` nie musi być dodawany do repozytorium, jeżeli zależności są instalowane przez Composer.

## Przykładowe zapytanie Elasticsearch

Aplikacja wyszukuje dokumenty przy pomocy zapytania typu `bool should`, sprawdzając jednocześnie treść dokumentu oraz nazwę pliku:

```php
'query' => [
    'bool' => [
        'should' => [
            ['match' => ['content' => $q]],
            ['match' => ['filename' => $q]]
        ]
    ]
]
```

## Możliwe usprawnienia

- dodanie obsługi paginacji wyników,
- dodanie wyboru indeksu Elasticsearch w konfiguracji,
- dodanie obsługi błędów połączenia z Elasticsearch,
- zabezpieczenie danych wejściowych użytkownika,
- poprawienie generowania linków do plików PDF,
- dodanie pliku `.env` dla konfiguracji środowiskowej,
- dodanie pliku `.gitignore`,
- przygotowanie automatycznej konwersji PDF do TXT.

## Przykładowy `.gitignore`

```gitignore
/vendor/
__pycache__/
*.pyc
.env
.DS_Store
```

## Autor

Projekt przygotowany jako prosta wyszukiwarka dokumentów oparta o Elasticsearch.

## Licencja

Brak określonej licencji. Przed publicznym udostępnieniem projektu warto dodać plik `LICENSE`.
