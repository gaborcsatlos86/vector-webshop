# Vector – Teszt Webshop
## Követelmények
Az alkalamazás PHP kódbázison alapuló webes fejleszté. A kiszolgálásához elengedhetetlen a PHP 8.2 es verziója. Továbbá adatbázi kezelőt használ, mely lehet mysql, mariaDB vagy postgre is. A weboldal kiszolgálására tetszés szerint lehet használni ngnix vagy apache2 kiszolgálót. 
## Telepítés
A zip állományt Document Root könyvtárba kell kicsomagolni. Az alkalamazás futtatásához az index.php a public mappában lesz találhsató. Oda kell irányítani a forgalmat.
## ENV
A .env fájlban működéshez elengedhetetlen konfigurációt kell megadni!
    • DATABASE_URL

### DATABASE_URL
Az adatbázis kapcsolat paramétere.
"mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
adatbázis-kezelő://adatbázis-felhasználó:adatbázis-felhasználó-jelszava@adatbázis-ip-címe:portja/adatbázis-db-neve?egyéb-paraméteretk
## Composer
Az alkalamazás composer telepítőt használ. Ez egy php alapó mikro alkalmazás, a fájlrendszer gyökerében is megtalálható.
Futtatása: az alkalmazás gyökerében!
$ php composer install
Ennek lefutása elengedhetetlen. Felmerülhetnek első körben hibás lefutások, melyek informatívan tájékoztatnak majd a problémáról. Ilyen lehet egy csomag php bővítmény igénye. Ezeket szintén fel kell telepíteni, ha minden bővítmény rendelkezésre áll, az alklalmazás már majdnem kész.
## Symfony
Pár alapvető parancsot kell alkalmazni a gyökérben állva.
```bash
$ php bin/console cache:clear
$ php bin/consol assets:install
```

Telepítés során kötelező parancsok:
```bash
$ php bin/consol doctrine:migrations:migrate ← adatbázis schema létrehozása
$ php bin/consol doctrine:fixtures:load ← teszt adatok feltöltése
```

cache:clear parancs kiadása időszakosan is ajánlott.

Alkalamazás indítása megkezdődhet db sql dump importálásával vagy egy tiszta, üres adabázissal. 
```bash
$ php bin/console doctrine:migrations:migrate
```
Ezzel létrehozzuk a táblákat.
```bash
$ php bin/console doctrine:fixtures:load
```
Itt majd kér megerősítést. Ezt követően az adatbázi bizonyos táblái feltöltődnek induláshoz fontos rekordokkal.
## Alkalmazás felépítése
### Portál
A publikus felülettel találkozunk az oldal betöltődését követően. Lehetőségünk van új felhasználót regisztrálni, valamint meglévővel belépni. Az ezekhez szükséges aloldalakhoz az elérhetőség a tartalmi rész jobb tetején találjuk a gombokat. Bal oldalt a navigációs szekcióban találunk egy kategória fát, valamint a webáruház kosár funkciója is itt foglal helyet. A különböző kategóriák között navigálva találjuk az adott kategória alatt elhelyezkedő termékeket. A termékek kártyák formájában elérhetőek, a készleten lévő termékeket kosárba tudjuk tenni. A kártyákon a termék nevét, leírását, cikkszámát valamint aktuális árát tudjuk leolvasni.
A kosárba rakott termékeket tudjuk módosítani, hogy többet vagy kevesebbet szeretnénk. Valamint a kosár tartalmát ki is tudjuk üríteni. A kosár tartalma dinamikusan frissül. Ha nem üres a kosarunk, rá tudunk menni a rendelés rögzítése funkcióra.
Rendelés összegzésénél előtöltünk pár alap adatot (név és cím) ha be vagyunk jelentkezve. A termék lista már nem módosítható. Rendelés rögzítését csak belépett felhasználó végezheti el. Ha még ekkor is van elérhető raktárkészlet minden termékből, akkor a rendelés rögzítése sikerrel lezajlik. Erről megerősítő üzenetet kapunk. Ennek hatására a raktárkészelt változni fog.
### Admin
Az admin felület csupán adminisztrátori jogosultsággal érhető el a /admin aloldalon.
Ide belépve lehetőséget kapunk a Felhasználó kezelő, Webáruház Termék és Megrendelések lista eléréshez, valamint a Kategória fa bővítéséhez.
Rögzíthetünk új termékeket, meglévőeket módosíthatunk. Megrendelések állapotát módosíthatjuk.