<h1>Cache leeren</h1>
<?php
 // rec_rmdir - loesche ein Verzeichnis rekursiv
// Rueckgabewerte:
//   0  - alles ok
//   -1 - kein Verzeichnis
//   -2 - Fehler beim Loeschen
//   -3 - Ein Eintrag eines Verzeichnisses war keine Datei und kein Verzeichnis und
//        kein Link
     function rec_rmdir($path) {
        // schau' nach, ob das ueberhaupt ein Verzeichnis ist
        if (!is_dir($path)) {
	  echo $_SERVER["DOCUMENT_ROOT"];
            return -1;
        }
        // oeffne das Verzeichnis
        $dir = @opendir($path);

        // Fehler?
        if (!$dir) {
            return -2;
        }

        // gehe durch das Verzeichnis
        while (($entry = @readdir($dir)) !== false) {
            // wenn der Eintrag das aktuelle Verzeichnis oder das Elternverzeichnis
            // ist, ignoriere es
            if ($entry == '.' || $entry == '..')
                continue;
            // wenn der Eintrag ein Verzeichnis ist, dann 
            if (is_dir($path . '/' . $entry)) {
                // rufe mich selbst auf
                $res = rec_rmdir($path . '/' . $entry);
                // wenn ein Fehler aufgetreten ist
                if ($res == -1) { // dies duerfte gar nicht passieren
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // normalen Fehler melden
                } else if ($res == -2) { // Fehler?
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // Fehler weitergeben
                } else if ($res == -3) { // nicht unterstuetzer Dateityp?
                    @closedir($dir); // Verzeichnis schliessen
                    return -3; // Fehler weitergeben
                } else if ($res != 0) { // das duerfe auch nicht passieren...
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // Fehler zurueck
                }
            } else if (is_file($path . '/' . $entry) || is_link($path . '/' . $entry)) {
                // ansonsten loesche diese Datei / diesen Link
                $res = @unlink($path . '/' . $entry);
                // Fehler?
                if (!$res) {
                    @closedir($dir); // Verzeichnis schliessen
                    return -2; // melde ihn
                }
            } else {
                // ein nicht unterstuetzer Dateityp
                @closedir($dir); // Verzeichnis schliessen
                return -3; // tut mir schrecklich leid...
            }
        }

        // schliesse nun das Verzeichnis
        @closedir($dir);

        // versuche nun, das Verzeichnis zu loeschen
        $res = @rmdir($path);

        // gab's einen Fehler?
        if (!$res) {
            return -2; // melde ihn
        }

        // alles ok
        return 0;
    }
 
echo "prod".rec_rmdir("/var/customers/webs/alf/liga-net.de/app/cache/prod");
echo "dev".rec_rmdir("/var/customers/webs/alf/liga-net.de/app/cache/dev");
?>