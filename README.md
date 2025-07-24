# Diagram procesu grafikowania Call Center

## 🧑‍💼 Role:
- **Agent Call Center** – zgłasza swoją dostępność, posiada określone kompetencje i efektywność.
- **Manager** – zatwierdza grafik, monitoruje pokrycie zapotrzebowania.
- **System Grafikowania (aplikacja)** – zbiera dane, generuje grafik, optymalizuje przypisania.

---

## 🔁 Proces krok po kroku:

### 1. Deklaracja dostępności przez agentów
**Agent → System**
- Agent loguje się do systemu i podaje swoją dostępność godzinową na nadchodzący tydzień.
- System zapisuje dostępność z podziałem na dni, godziny oraz dostępne kolejki.

### 2. Wczytanie danych historycznych i predykcji
**System**
- Importuje historię połączeń z poprzednich tygodni.
- Generuje predykcję zapotrzebowania (liczba połączeń/h/godzina na każdej kolejce).
- Ustala oczekiwaną liczbę agentów dla każdej kolejki na każdą godzinę.

### 3. Dopasowanie agentów do zapotrzebowania
**System**
- Na podstawie dostępności, kompetencji i efektywności agentów:
    - Dobiera agentów do slotów czasowych na kolejkach.
    - Minimalizuje liczbę nadmiarowych przypisań.
    - Maksymalizuje pokrycie zapotrzebowania z uwzględnieniem efektywności.

### 4. Weryfikacja i zatwierdzenie grafiku
**Manager → System**
- Manager przegląda wygenerowany grafik.
- System prezentuje alerty: niedopasowania, niedobory, nadmiary.
- Manager może ręcznie korygować przypisania.

### 5. Publikacja grafiku
**System → Agent**
- Agent otrzymuje informację o przydzielonych godzinach i kolejkach.
- System umożliwia późniejsze zgłoszenie niedyspozycyjności (do zatwierdzenia przez managera).

---

## 🔄 Modyfikacje post-grafikowania
**Agent/Manager**
- Agent może zaktualizować swoją dostępność lub zgłosić nieobecność.
- Manager dokonuje reoptymalizacji grafiku w razie istotnych zmian (np. nieobecności, wzrost zapotrzebowania).

---

## 📈 Mierzenie efektywności grafiku
**System**
- Analizuje stopień pokrycia zapotrzebowania.
- Wskazuje luki w grafiku i niewykorzystane moce przerobowe.
- Tworzy raporty dla managera.

---

## 🧠 Uproszczenia przyjęte w prototypie:
- Historia połączeń i predykcja są symulowane (losowe dane + heurystyka).
- Efektywność agenta to liczba 0–1 przypisana ręcznie.
- Algorytm przypisania: wersja heurystyczna (greedy matching lub scoring).

---

# Diagram procesu grafikowania Call Center

```text
┌──────────────────────────────┐
│      Agent Call Center       │
└────────────┬────────────────┘
             │
             │ 1. Deklaruje dostępność (dni/godziny)
             ▼
┌──────────────────────────────┐
│    System grafikowania       │
│  (Backend + DB + Frontend)   │
└────────────┬────────────────┘
             │
             │ 2. Pobiera dane:
             │    - Historia połączeń
             │    - Predykcja zapotrzebowania
             ▼
┌──────────────────────────────┐
│  Analiza zapotrzebowania     │
│  na podstawie predykcji      │
└────────────┬────────────────┘
             │
             │ 3. Przypisuje agentów do kolejek
             │    na podstawie:
             │     - dostępności
             │     - kompetencji
             │     - efektywności
             ▼
┌──────────────────────────────┐
│    Wygenerowany grafik       │
│    + status pokrycia         │
└────────────┬────────────────┘
             │
             │ 4. Przegląda i zatwierdza
             ▼
┌──────────────────────────────┐
│           Manager            │
└────────────┬────────────────┘
             │
             │ 5. Ewentualna korekta
             ▼
┌──────────────────────────────┐
│    Opublikowany grafik       │
│    → info do agentów         │
└────────────┬────────────────┘
             │
             │ 6. Ewentualne zmiany (NDA, korekty)
             ▼
┌──────────────────────────────┐
│  System – reoptymalizacja    │
└────────────┬────────────────┘
             │
             ▼
┌──────────────────────────────┐
│     Raporty i alerty         │
│  (pokrycie, niedobory, itp.) │
└──────────────────────────────┘
```
