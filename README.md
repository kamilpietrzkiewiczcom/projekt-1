# projekt-1

## Zapytania curl

### utworzenie kategorii

curl --location 'http://zadanie.test/index.php/category' --form 'code="test2"'

### kasowanie kategorii



### pobranie listy kategorii

curl --location 'http://zadanie.test/index.php/categories'

### 

## Stack technologiczny:

🚀 Symfony – najnowsza stabilna wersja. MySQL – bo dane trzeba gdzieś trzymać.
🌐 API Platform – mile widziane, ale niekonieczne. 🐳 Docker – dla łatwej konfiguracji i uruchomienia.

## Wymagania:

### ✔ Encje:
Produkt: id, nazwa, cena, data dodania, data aktualizacji.
Kategoria: id, kod (unikalny, max 10 znaków), data dodania, data aktualizacji.
Produkt musi należeć do co najmniej jednej kategorii.

### ✔ Walidacja:
Pole kod w kategorii musi być unikalne i nie dłuższe niż 10 znaków.
Daty dodania i aktualizacji muszą ustawiać się automatycznie.

### ✔ Funkcjonalności API:
Dodawanie, aktualizowanie, usuwanie i pobieranie produktów.
Powiązanie produktu z kategoriami.

### ✔ Notyfikacje:
Po zapisaniu produktu i powiązanych kategorii:

Zapisz log operacji.
Wyślij e-mail (może być fikcyjny, ale struktura powinna być gotowa).
Projekt powinien być gotowy do łatwej rozbudowy o inne powiadomienia, np. Slack, SMS.

### ✔ Testy:
PHPUnit – napisz testy do fragmentu kodu wysyłającego powiadomienia.

### ✔ Dokumentacja:
README.md – instrukcja instalacji, konfiguracji i uruchomienia projektu.
