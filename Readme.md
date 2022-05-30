# Convertis Homepage Banners

![Generic badge](https://img.shields.io/badge/Prestashop-1.6-<COLOR>.svg)
![Generic badge](https://img.shields.io/badge/Prestashop-1.7-<COLOR>.svg)

**Build 2022.05.30**

Moduł pozwala zdefiniować trzy boksy obrazkowe z opisami i linkami na stronie głównej.

Jeśli dodatkowo będzie wgrany moduł `cv_webp` oraz włączona będzie opcja "Generuj obrazki webp", wówczas wgrywane grafiki zostaną przekonwertowane na format webp.

Moduł działa z multistore oraz wieloma językami.

---

## Instrukcja

* ### Instalacja/aktualizacja modułu poprzez composera:

    * zmodyfikować plik `./composer.json`:
        * w sekcji "require" dopisać: 
            ```
            "pityon/cv_3foto_links": "dev-master"
            ```
        * w sekcji "repositories" dopisać:
            ```
            {
                "type": "vcs",
                "url": "https://github.com/pityon/cv_3foto_links"
            }
            ```
    * po zmodyfikowaniu głównego pliku composer.json można wywołać komendę: `composer update pityon/cv_3foto_links`
    * moduł zostanie pobrany i zapisany pod ścieżką `./modules/cv_3foto_links`
    * jeśli moduł już istniał wcześniej pod tą ścieżką, to komenda zamiast tego spróbuje zaktualizować moduł do najnowszej wersji (jeśli oczywiście jest nowsza wersja na github)

    ---

* ### Modyfikacja plików SCSS:
    * żeby zmodyfikować pliki scss, konieczne jest posiadanie gulpa wraz z modułami, w tym celu należy udać się do folderu z modułem i wywołać komendę: `npm install`
    * NPM pobierze wszystkie potrzebne rzeczy i zapisze w folderze node_modules, od tego momentu można modyfikować pliki scss wywołując jedną z trzech komend: 
        * `gulp watch` lub 
        * `gulp` lub
        * `npm run watch`