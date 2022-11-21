# Merce Rest Client
    Author Ihor-Severyn Dolhopolov
    Projekt został stworzony na potrzeby rekrutacyjne merce.com
    Projekt spełnia pierwszą część zadania rekrutacyjnego

# Podjęte decyzje projektowe
    Zostały użyte następujące standardy
    PSR-1/PSR-2/PSR-12  coding standarts
    PSR-4               autoload
    PSR-7               http message interface
    PSR-15              http middleware
    PSR-16              cache interface
    PSR-17              http factories
    PSR-18              http client

#    Struktura biblioteki merce-rest-client
>### HttpPlug moduł służy jako wtyczka do wysyłania żądań http
>*    Struktura modułu 
>*    Middleware – zestaw klas, które mają być włączone przed i po wysłaniu zadania http
>*    MiddlewareContainer – definiuje kolejność wykonywania klas
>*    Support – metody pomocnicze 
>*    HttpPlugController – kontroler modułu
>
>### AuthTokenPlug moduł służy jako wtyczka do obsługi tokenów autoryzacji
>*    TokenManager – kontroler tokenów
>*    TokenParser – parser tokenów
>*    Cechy
>*    Moduł jest przygotowany aby obsługiwać różne typy tokenów
>*    JWTAuthToken
>*    Moduł implementuje cache dla tokenów
>*    Moduł automatycznie odświeża token po wygaśnięciu

# Tests
    ./vendor/bin/phpunit --testsuite Unit
