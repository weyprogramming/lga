# Bessere Google-Sichtbarkeit für das Landgasthaus Albermann

Hallo! Hier ist alles gesammelt, damit eure Website bei Google besser gefunden wird – vor allem bei Suchen wie „Restaurant Rheda-Wiedenbrück“ oder „westfälische Küche in der Nähe“.

**Kurz gesagt:** Die Website ist technisch in Ordnung. Es fehlen aber ein paar Dinge, auf die Google bei Restaurants besonders achtet. Die Schritte unten sind nach Wirkung sortiert – die ersten drei bringen am meisten und brauchen keine Technik.

Du brauchst dafür nur einen Browser, den Zugang zum WordPress-Backend und ein Google-Konto.

---

## Was in diesem Ordner liegt

| Datei | Wofür |
|---|---|
| `albermann-speisekarte.zip` | Ein kleines WordPress-Plugin: Damit pflegst du die Abendkarte direkt in WordPress, statt nur ein PDF hochzuladen (Schritt 4). |
| `structured-data.html` | Ein Textbaustein, der Google Adresse, Telefon und Öffnungszeiten in maschinenlesbarer Form mitteilt (Schritt 5). |
| `menu.html` | Eine Vorschau, wie die Karte als Webseite aussieht. Zum Anschauen im Browser doppelklicken. Hieraus kannst du auch den Text der Allergikerhinweise kopieren. |
| `wordpress/` | Der Inhalt des Plugins zum Nachschauen. Für dich nicht wichtig. |

> In der Vorschau `menu.html` sehen die Schriften schlichter aus als später auf eurer Website. Das ist normal: Eure Schriften laden nur auf eurer eigenen Domain.

---

## Schritt 1: Google-Unternehmensprofil pflegen ⭐ wichtigster Schritt

Das ist der Eintrag, der bei Google Maps und rechts neben den Suchergebnissen erscheint. Für Restaurants zählt er mehr als die Website selbst.

1. Öffne [business.google.com](https://business.google.com) und melde dich mit eurem Google-Konto an.
2. Falls das Landgasthaus noch nicht „beansprucht“ ist: Eintrag suchen und auf „Inhaber bestätigen“ klicken. Google schickt meist eine Postkarte mit Code oder ruft an.
3. Fülle alles aus:
   - Öffnungszeiten (genau wie auf der Website), auch Feiertage und Ruhetage
   - Kategorie „Restaurant“, dazu z. B. „Deutsches Restaurant“ und „Hotel“
   - Link zur Website und zur Speisekarte (`https://landgasthaus-albermann.de/abendkarte/`)
   - Möglichst viele gute Fotos: Gastraum, Terrasse, Gerichte, Außenansicht
4. Beantworte Bewertungen – auch die guten, ein kurzes „Danke“ reicht.

## Schritt 2: Gäste um Google-Bewertungen bitten

Anzahl und Aktualität der Bewertungen beeinflussen stark, wer bei Google Maps oben steht.

- Im Unternehmensprofil gibt es unter „Mehr Rezensionen erhalten“ einen Link bzw. QR-Code.
- Den QR-Code z. B. auf die Rechnung, einen Tischaufsteller oder die Karte drucken.
- Zufriedene Stammgäste einfach direkt fragen.

## Schritt 3: Öffnungszeiten überall gleich halten

Google vergleicht eure Angaben auf verschiedenen Seiten. Widersprüche kosten Vertrauen und Platzierungen.

Gerade aufgefallen: Auf eurer Kontaktseite steht **Mi–Sa**, auf [dein-nrw.de](https://entdecke.dein-nrw.de/en/dein-nrw/streaming/detail/Gastro/g_100021428/landgasthaus-albermann) steht **Di–Sa** (und „zweite Generation“ statt „dritte“).

Prüfe und korrigiere Name, Adresse, Telefonnummer und Öffnungszeiten auf:

- [ ] Google-Unternehmensprofil
- [ ] eurer Website (Kontaktseite, Fußzeile)
- [ ] dein-nrw.de
- [ ] 11880.com
- [ ] Tripadvisor
- [ ] Facebook und Instagram

**Merke:** Wenn sich die Öffnungszeiten ändern, an all diesen Stellen ändern – und in Schritt 5.

---

## Schritt 4: Speisekarte als echte Webseite

Bisher gibt es die Abendkarte nur als PDF. Google kann darin schlecht lesen. Als normaler Text auf einer Seite findet man euch dann auch bei Suchen wie „Wildragout Rheda-Wiedenbrück“.

### Einmalig einrichten (ca. 15 Minuten)

**Plugin installieren**

1. Im WordPress-Backend links auf **Plugins → Neues Plugin hinzufügen** klicken.
2. Oben auf **Plugin hochladen** klicken und die Datei `albermann-speisekarte.zip` auswählen.
3. **Jetzt installieren**, danach **Aktivieren**.

Links im Menü gibt es jetzt den Punkt **Speisekarte**. Die aktuelle Abendkarte (September 2026) ist dort schon komplett eingetragen.

**Seite anlegen**

1. **Seiten → Erstellen**, Titel: **Abendkarte**.
2. Die Seitenadresse (Permalink) muss `abendkarte` sein, also `landgasthaus-albermann.de/abendkarte/`.
3. Mit Elementor bearbeiten und so aufbauen wie eure anderen Seiten (Kopfzeile, Bild usw.).
4. An der Stelle, wo die Karte erscheinen soll, das Element **Shortcode** hineinziehen und dort eintragen:

   ```
   [abendkarte]
   ```

5. Darunter ein **Text-Editor**-Element mit dem Gutschein-Hinweis und den Allergikerhinweisen. Den Text kannst du aus der Vorschau `menu.html` kopieren.
6. Optional: Einen Button „Karte als PDF“ mit dem bisherigen PDF dazusetzen.
7. **Veröffentlichen**.

**Verlinken**

- Auf der Restaurant-Seite einen Button „Zur Abendkarte“ setzen, der auf die neue Seite führt.
- Im Hauptmenü unter **Design → Menüs** (oder im Elementor-Header) einen Punkt „Speisekarte“ ergänzen.

### Die Karte ändern (jeden Monat)

Alles unter **Speisekarte** im linken WordPress-Menü – kein HTML, keine Technik.

| Was du willst | So geht’s |
|---|---|
| Gericht ändern (Name, Beschreibung, Preis) | **Speisekarte → Alle Gerichte**, Gericht anklicken, ändern, **Aktualisieren**. |
| Neues Gericht | **Speisekarte → Gericht hinzufügen**. Name oben eintragen, darunter Beschreibung und Preis, rechts den **Kartenbereich** anhaken. |
| Gericht entfernen | In der Liste mit der Maus über das Gericht fahren → **Papierkorb**. |
| Reihenfolge der Gerichte | Im Gericht rechts unten im Kasten **Reihenfolge**. Kleinere Zahl = weiter oben (z. B. 10, 20, 30 – dann kannst du später 15 dazwischenschieben). |
| Neuer Bereich, z. B. „Spargelzeit“ | **Speisekarte → Kartenbereiche**. Name, **Reihenfolge auf der Karte** und ggf. **Menüpreis** eintragen. |
| Menü mit Gesamtpreis (z. B. „Herbstmenü 79 €“) | Den Preis beim **Kartenbereich** als Menüpreis eintragen und bei den einzelnen Gerichten das Preisfeld leer lassen. |
| Bereich ausblenden | Einfach alle Gerichte darin in den Papierkorb legen – leere Bereiche erscheinen nicht. |
| Aufpreis, z. B. Garnelen dazu | Im Feld **Zusatz** schreiben: `oder mit 3 Black Tiger Garnelen (+9 €)` |

**Tipp:** Ein Gericht, das sowohl im Menü als auch einzeln auf der Karte steht (z. B. die Ochsenbacke), ist zweimal eingetragen – einmal ohne Preis im Menü, einmal mit Preis im Bereich „Vom Land und der Weide“. Beim Ändern beide anpassen.

Google erhält die Karte automatisch in maschinenlesbarer Form mit – darum musst du dich nicht kümmern.

---

## Schritt 5: Adresse und Öffnungszeiten für Google hinterlegen

Die Datei `structured-data.html` enthält einen unsichtbaren Baustein, der Google genau sagt: Das ist ein Restaurant, hier ist die Adresse, das sind die Öffnungszeiten, hier ist die Karte.

### Vorher anpassen

Öffne die Datei mit einem einfachen Texteditor (Mac: **TextEdit**, Windows: **Editor**) und prüfe:

- **Ganz unten bei `sameAs`:** Die beiden Zeilen mit `…` durch die echten Links zu eurer Facebook- und Instagram-Seite ersetzen. Habt ihr eines davon nicht, die Zeile löschen (und auf das Komma achten: nach dem letzten Eintrag darf keins stehen).
- **`priceRange`:** „€€“ heißt „mittleres Preisniveau“. Passt das?
- **`openingHoursSpecification`:** Stimmen die Öffnungszeiten? Aktuell eingetragen: Mi–Sa 17:30–22:00 Uhr, So 11:30–14:00 und 17:30–22:00 Uhr.

### Einbauen

1. **Plugins → Neues Plugin hinzufügen**, nach **WPCode** suchen („WPCode – Insert Headers and Footers“), installieren und aktivieren.
2. Links **Code Snippets → Snippet hinzufügen → Eigenen Code hinzufügen**.
3. Name: „Google Restaurant-Daten“, Codetyp: **HTML-Snippet**.
4. Den kompletten Inhalt von `structured-data.html` hineinkopieren.
5. Unten bei **Einfügen**: Ort **Seitenweiter Header** (Site Wide Header).
6. Oben auf **Aktiv** stellen und **Speichern**.

### Prüfen

Öffne den [Google Rich Results Test](https://search.google.com/test/rich-results), gib `https://landgasthaus-albermann.de/` ein und klicke auf **URL testen**. Es sollte „Restaurant“ bzw. „Lokales Unternehmen“ ohne Fehler erscheinen. Dasselbe für `/abendkarte/` – dort sollte die Speisekarte erkannt werden.

**Wichtig:** Ändern sich die Öffnungszeiten, auch diesen Baustein in WPCode anpassen. Falsche Zeiten hier schaden mehr, als sie nutzen.

---

## Schritt 6: Google Search Console einrichten

Hier zeigt Google dir, wie es eure Seite sieht: Bei welchen Suchbegriffen ihr erscheint, wie oft man klickt und ob es Probleme gibt.

1. [search.google.com/search-console](https://search.google.com/search-console) öffnen, mit demselben Google-Konto anmelden.
2. **Domain** wählen und `landgasthaus-albermann.de` eingeben. Zum Bestätigen muss ein Eintrag beim Webhoster gemacht werden – das kann euer Webdesigner oder Hoster in 5 Minuten erledigen.
   *Einfacher:* **URL-Präfix** wählen und mit dem Yoast-Plugin bestätigen (Yoast SEO → Einstellungen → Website-Verbindungen → Google).
3. Links **Sitemaps** → `sitemap_index.xml` eintragen → **Senden**.
4. Nach Veröffentlichung der Abendkarte: Oben die Adresse `https://landgasthaus-albermann.de/abendkarte/` eingeben → **Indexierung beantragen**.

Nach ein paar Tagen siehst du unter **Leistung**, bei welchen Suchen ihr auftaucht.

## Schritt 7: Bessere Seitentitel und Beschreibungen

Das ist der blaue Titel und der graue Text darunter in den Google-Ergebnissen. Bisher heißt es z. B. nur „Restaurant - Albermann“ – darin fehlen der Ort und die Küche, und alle Unterseiten haben dieselbe Beschreibung.

So änderst du es: Seite in WordPress öffnen → unten (oder rechts) im Bereich **Yoast SEO** die Felder **SEO-Titel** und **Meta-Beschreibung** ausfüllen → **Aktualisieren**.

| Seite | SEO-Titel | Meta-Beschreibung |
|---|---|---|
| Restaurant | Restaurant in Rheda-Wiedenbrück – westfälische Küche \| Landgasthaus Albermann | Westfälische und saisonale Küche in dritter Generation: Wild, Schnitzel-Klassiker und Menüs im Landgasthaus Albermann in Rheda-Wiedenbrück. Jetzt Tisch reservieren. |
| Abendkarte | Abendkarte – Speisekarte \| Landgasthaus Albermann Rheda-Wiedenbrück | Unsere aktuelle Abendkarte: westfälisches Menü, Herbstmenü, Schnitzel-Klassiker, Wildragout, Fisch, vegetarische Gerichte und Desserts. |
| Hotel | Hotel in Rheda-Wiedenbrück – Zimmer im Landgasthaus Albermann | Gemütliche Zimmer im Landgasthaus Albermann in Rheda-Wiedenbrück – mit Restaurant im Haus. Ideal für Geschäftsreisende und Urlauber. Jetzt anfragen. |
| Catering & Feiern | Feiern & Catering in Rheda-Wiedenbrück \| Landgasthaus Albermann | Hochzeit, Geburtstag oder Firmenfeier: Wir richten Ihre Feier im Landgasthaus aus oder liefern Catering in Rheda-Wiedenbrück und Umgebung. |
| Kontakt | Kontakt & Anfahrt \| Landgasthaus Albermann, Rheda-Wiedenbrück | Landgasthaus Albermann, Beckumer Straße 22, 33378 Rheda-Wiedenbrück. Telefon 05242 34642. Öffnungszeiten, Anfahrt und Reservierung. |

Die Texte sind Vorschläge – passt sie gern an, wenn etwas nicht stimmt (z. B. was die Zimmer besonders macht). Die Startseite ist schon gut und kann bleiben.

## Schritt 8: Alte Testseiten entfernen

Google zeigt ein paar Überbleibsel aus der Einrichtung von WordPress an, die nicht zu euch gehören:

- [ ] **Seiten:** „Sample Page“ und die Seite unter `/elementor-10/` (eine fehlerhafte Kopie der Startseite) → in den Papierkorb.
- [ ] **Beiträge:** „Hello world!“ → in den Papierkorb.
- [ ] **Yoast SEO → Einstellungen → Kategorien & Schlagwörter → Kategorien:** „In Suchergebnissen anzeigen“ ausschalten.
- [ ] **Yoast SEO → Einstellungen → Erweitert → Autorenarchive:** ausschalten.

Vor dem Löschen kurz ansehen, ob die Seite wirklich nirgends gebraucht wird.

## Schritt 9: Website schneller machen

Die Startseite braucht teilweise bis zu 10 Sekunden, bis sie lädt. Das verärgert Gäste auf dem Handy und Google bewertet es schlechter.

1. Ein Caching-Plugin installieren. Eines davon reicht:
   - **WP Super Cache** – kostenlos, einfach: installieren, aktivieren, unter **Einstellungen → WP Super Cache** auf **Caching an** stellen.
   - **WP Rocket** – kostenpflichtig (ca. 60 €/Jahr), aber mit den meisten Verbesserungen auf einen Klick.
2. Unter **Plugins** prüfen, welche Elementor-Erweiterungen (z. B. „Happy Elementor Addons“) wirklich genutzt werden, und ungenutzte deaktivieren. **Vorsicht:** Danach jede Seite einmal ansehen, ob noch alles richtig aussieht. Im Zweifel den Webdesigner fragen.
3. Vorher ein Backup machen (viele Hoster bieten das im Kundenbereich an).

## Schritt 10: Bilder beschriften

Keines der Bilder auf der Startseite hat einen Beschreibungstext („Alternativtext“). Google kann Bilder nicht sehen und liest diesen Text – außerdem hilft er sehbehinderten Gästen.

1. **Medien → Mediathek**, Bild anklicken.
2. Bei **Alternativer Text** kurz beschreiben, was zu sehen ist, z. B. „Gastraum im Landgasthaus Albermann mit gedeckten Tischen“ oder „Rosa gebratenes Kalbsfilet mit Brokkoli“.
3. Außerdem: Unter **Yoast SEO → Einstellungen → Website-Grundlagen** ein schönes Foto als **Standard-Vorschaubild** hochladen. Das erscheint, wenn jemand eure Seite bei WhatsApp oder Facebook teilt (bisher steht dort ein Platzhalter).

---

## Checkliste zum Abhaken

- [ ] 1. Google-Unternehmensprofil vollständig ausgefüllt
- [ ] 2. QR-Code für Bewertungen ausgedruckt
- [ ] 3. Öffnungszeiten überall gleich
- [ ] 4. Speisekarten-Plugin installiert, Seite „Abendkarte“ veröffentlicht und verlinkt
- [ ] 5. Restaurant-Daten über WPCode eingebaut und im Rich Results Test geprüft
- [ ] 6. Search Console eingerichtet, Sitemap gesendet
- [ ] 7. Seitentitel und Beschreibungen geändert
- [ ] 8. Testseiten entfernt
- [ ] 9. Caching-Plugin aktiv
- [ ] 10. Bilder beschriftet, Vorschaubild gesetzt

**Geduld:** Google braucht nach Änderungen meist 2–8 Wochen, bis sich die Platzierungen sichtbar verbessern. Die Search Console (Schritt 6) zeigt, ob es vorangeht.

Bei Fragen einfach bei Lennart melden.
