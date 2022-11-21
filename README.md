# Merce Rest Client
    Author Ihor-Severyn Dolhopolov
    Projekt został stworzony na potrzeby rekrutacyjne merce.com
    Projekt spełnia pierwsza cześć zadania rekrutacyjnego

# Podjete decyzje projektowe
    Zostały użyte następujące standardy
    PSR-1/PSR-2 coding standarts
    PSR-7       http message interface
    PSR-17      http factories
    PSR-15      http middleware
    PSR-16      cache interface
    PSR-18      http client

# JWTTokenManager 
    Klasa obsługuje jwt tokeny
    Klasa inicjalizuję się za pomocą loginu/hasła użytkownika, zarwano jak i url do logowania
    Klasa automatycznie odświeża token w przypadku wygaśnięcia
