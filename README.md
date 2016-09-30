Diese Software bedient sich der REST-API der Deutschen Bahn, um die Verfügbarkeit von Parkplätzen
in der Nähe von Bahnhöfen abzufragen.

Dazu wird auf der Webseite ein Bahnhof ausgewählt. Beim auswählen werden schon automatisch die
verfügbaren Bahnhöfe geladen. Sollte man die Informationen aktualisieren wollen oder aber
zu dem Bahnhof, der schon in der Liste ausgewählt ist, die Parkplätze auswählen, so kann
man das über den Button neben der Selectbox. 
 
Danach werden die Header der einzelnen Parkplätze angezeigt. In den Header zählt der Name 
des Parkplatzes, solange einer von der Deutschen Bahn vergeben wurde und die zur Zeit verfügbaren
Parkplätze. 
Außerdem sind die Header farblich hinterlegt. Grün für über 50 freie Parkplätze, Gelb für 30 bis 50, 
Orange für 10 bis 30 und Rot für weniger als 10. Blau hinterlegt sind die, zu denen die DB keine
Informationen herausgibt. 

Durch einen Klick auf den Header werden zusätzliche Informationen, wie der Tarif, die maximale
Parkdauer, der Verantwortliche des Parkplatzes oder ähnliches angezeigt. Außerdem wird der
Standort des Parkplatzes auf einer Karte angezeigt, um das Hinkommen zu diesem möglichst
einfach zu gestalten.
Unterhalb der Informationen gibt es noch eine Prognose, die die voraussichtlichen freien Parkplätze 
innerhalb der nächsten Woche anzeigt. 
Ein erneuter Klick auf den Parkplatz schließt ihn wieder.

Weiter unten erkläre ich die Installation und Bedienung

Zum Technischen: Ich habe diese Webapp mit ZendFramework 3 erstellt. Das bietet ein angenehmes
Model-View-Controller-Konzept und aus vorherigen Versuchen kannte ich mich einigermaßen
gut damit aus. Außerdem wurde noch Foundation und JQuery hauptsächlich benutzt, sowie Composer
um die Abhängigkeiten aufzulösen. Und Doctrine wurde für den Zugriff auf die Datenbank benutzt.

Der Kern der Applikation steckt in dem IndexController. Dieser hat zwei Actions, in der ersten
werden nur alle Bahnhöfe von der REST-API geladen und eine Selectbox wird mit diesen Informationen
vorbereitet, um diese dann in der View auszugeben. 
Die zweite Action bekommt die ID eines Bahnhofes übergeben, anhand die verfügbaren Parkplätze
gefiltert werden. Leider gibt es bei der API keine Möglichkeit alle Parkplätze zu einem Bahnhof
zu bekommen. Daher mussten alle Bahnhöfe geholt und nach der ID im Nachhinen gefiltert werden.
Zu diesen Bahnhöfen wurde dann auch direkt die Belegung geladen, wenn denn eine vorhanden war.
Die zweite Action wird per Ajax nachgeladen.

Da in dieser Action auch schon die Belegung der einzelnen Parkplätze geladen wird, wird diese
auch direkt in der Datenbank gespeichert, um daraus im Nachhinein die Prognosedaten zu laden.
Da jedoch davon auszugehen ist, dass besonders am Anfang nicht genügend Anfragen kommen, um für
alle Parkplätze auch sinnvolle Prognosen zu liefern, wurde ein zweiter Controller geschrieben.
Dessen einzige Action lädt lediglich alle zurzeit verfügbaren Informationen zu den freien 
Parkplätzen und speichert diese in der Datenbank. Diese Action ist, um das zumüllen der Datenbank
zu verhindern, nur über das CLI aufrufbar (Siehe weiter unten). 

Aus den Daten in der Datenbank werden dann defaultmäßig die Daten der letzten fünf Wochen geladen und
in 90-Minutenblöcke eingeteilt. Dabei gibt es jeden Wochentag nur einmal und es wird pro Zeiteinheit
der Durchschnitt als Prognose genommen. Zum Beispiel werden die Daten für Dienstags morgen um 7h bis
8:30 aus dem Durchschnitt der letzten fünf Dienstage von 7h bis 8:30 für diesen Bahnhof gewählt.
 
 
Zur Installation:
Die Software ist auch auf meinem Git-Repository-Repository (https://github.com/Ainias/DBParkplatzFinder)
und kann dort heruntergeladen werden. Zur entgültigen Installation wird jedoch composer benötigt.
Mit dem Befehl `composer install -n` im Rootverzeichnis der Software werden alle Komponenten installiert.
Danach müssen noch die MySQL-Befehle aus dem Script database.sql im Ordner orga ausgeführt werden.
Die Datenbank darf dabei umbenannt werden, muss dann auch im Code umbeannt werden.
In dem Ordner config/autolad gibt es die zwei dateien dev.local.php und prod.local.php.
Innerhalb dieser Dateien werden lokale Abhängigkeiten geregelt, wie die Authentifizierung an
der Datenbank. Durch die Konstante `HTTP_APPLICATION_ENV`, die z.B. im VHost der jeweiligen Umgebung erstellt werden 
kann, wird geregelt welche der beiden Dateien geladen wird. Sollte diese Konstante nicht gesetzt sein,
so wird dev.local.php geladen. 
Neben der Authentifizierung an der Datenbank gibt es in den Dateien auch noch die zwei Parameter 
timePeriodForPredictionInDays und numberTimeSegmentsPerDay. Der erste regelt wie viele Tage
aus der Vergangenheit die Daten für die Prognose geladen werden, während der zweite Parameter
regelt, wie viele ZeitSegmente es pro Tag gibt. Es wurde extra die Anzahl der Zeitsegmente 
gewählt und nicht die Minuten pro Zeitsegment, da dort man auch eine Anzahl wählen könnte, durch die
sich der Tag nicht teilen lässt. Es hat sich gezeigt, dass ein Abstand von 90 Minuten und damit 
16 Zeitintervalle pro Tag ganz gut sind, da sich sonst das Diagramm auf dem Handy nicht mehr ordentlich
lesen lässt. 
Wichtig ist, dass der DocumentRoot der Webseite auf den public Ordner gelegt wird. Und ModRewrite
mit der Rewrite-Engine muss aktiviert sein.

Wie schon erwähnt, gibt es einen extra Controller mit Action der dafür sorgen soll, dass die Daten 
für die Prognose auch vorhanden sind. Diese lässt sich durch den Befehl `php console.php fetchOccupancy`  
ausführen. Es empfielt sich einen Cronjob laufenzulassen, der diese Action durch den Befehl  
jede halbe Stunde bis Stunde ausführt, damit die Daten aktuell bleiben. Wichtig, die Datei console.php
liegt im Root des Verzeichnisses und nicht im public-Ordner.

Bei weiteren Fragen, stehe ich gerne zur Verfügung:
silasg@web.de

Leider ist es etwas länger geworden als erwartet.

PS: in den Ordner log braucht der Webserver Schreibrechte, da dort Logdateien angelegt werden. 
