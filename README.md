## Blog REST API dokumentacija

Projekt je kreiran 15.2.2021. u 19:08, a u 19:20 obavljen first commit. (To navodim samo radi roka od 24 sata koji bio potreban za izradu REST API-ja).

Nakon kreiranja projekta pomoću composera sam dodao Passport, a od ostalih 3rd party paketa pomoću npm-a Vue, Vuetify i Vuex. Nakon obavljenih migracija sam seederom dodao u bazu korisnika s ulogom (role) **blogger**. Potom sam u AuthServiceProvider.php dodao sljedeće:

Passport::tokensCan([
            'do_anything' => 'Blogger',
            'can_comment' => 'Visitor',
        ]);

To su ujedno bila i prava za pojedinu ulogu. S obzirom da sam korisnika kreirao seederom, nakon podešavanja rute i controllera (kreiranje tokena nakon uspješnog logina) bilo je potrebno napraviti Unit test uspješnosti autorizacije kreiranog korisnika. To sam napravio u Postmanu (slika dolje).

![unit_test](https://github.com/severovicivan/Blog-Include/blob/main/Screenshots/unit_test.png?raw=true)

Isto sam provjerio i za logout. Umjesto POST requesta sam odabrao GET, a u Headeru poslao key *Authorization* i value *Bearer token* (token predstavlja value tokena). U controlleru je na logout ruti trebalo postaviti user()->token()->revoke(). Kako bi provjerio funkcionira li API, postavio sam Vue komponentu unutar view-a **spa.blade.php**. Pomoću Vuex storea je prilikom logina usera pohranjeno njegovo stanje, a token prosljeđen u localStorage. Uspješno logiranje preusmjerava na SPA (Vue Single Page App) gdje su podaci prosljeđeni API-jem dostupni (slika dolje).

![unit_test](https://github.com/severovicivan/Blog-Include/blob/main/Screenshots/vue_accessible_token.png?raw=true)

Desno u inspectoru vidimo token, a lijevo na sidebaru dinamički dohvaćeno ime kod logout buttona koje je Vue komponenti proslijeđeno iz Vuex store modula **currentUser.js** prilikom uspješnog logina i promjene stanja usera preko mutatora. Što se blogova i komentara tiče moguće je još napraviti 2 modela, stvoriti odnose s userima i međusobno, a ograničenja prosljeđena tokenom (do_anything, can_comment) se mogu primjenjivati i na Vue SPA komponenti.
