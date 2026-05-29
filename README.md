# Course Extension

Diese TYPO3-Erweiterung ermöglicht den Import von Kursen aus verschiedenen Quellen (z.B. Leo von Labitzke events4viewture u.a.).
Sie bietet ein flexibles Framework zur Erweiterung um neue Datenquellen.

## Struktur der Erweiterung
Die Erweiterung folgt dem Standard-Layout für TYPO3-Extensions:

- `Classes/`: Enthält die Logik der Erweiterung.
  - `Dto/`: Data Transfer Objects (z.B. `RecordDto`) für die konsistente Datenhaltung während des Imports.
  - `Services/`: Zentrale Import-Logik.
    - `AbstractImportService.php`: Basisklasse für Datenbankoperationen und TYPO3 DataHandler-Integration.
    - `AbstractJsonImportService.php`: Erweitert die Basisklasse um JSON-Schema-Validierung.
- `Configuration/`: TCA-Definitionen und Service-Konfiguration (`Services.yaml`).
- `Resources/`: Private und öffentliche Ressourcen.
  - `Private/`: Enthält JSON-Schemas zur Validierung der Importdaten.
- `ext_tables.sql`: Datenbank-Definitionen.

## Datenstruktur
Die Kursdaten werden in der Tabelle `tx_course_domain_model_course` gespeichert.

### Wichtige Felder:
- `number`: Eindeutige Kursnummer (Identifier der Quelle).
- `course_type`: Typ des Kurses (z.B. Kurzbezeichnung).
- `course_description`: Ausführliche Beschreibung.
- `course_start_date` / `course_end_date`: Zeitstempel des Kurses.
- `address`: Relation zu `tt_address`.
- `import_id` & `import_source`: Felder zur Identifizierung der Herkunft und Vermeidung von Duplikaten.
- `categories`: Relation zu `sys_category`.

Zusätzlich wurde die Tabelle `tt_address` um `import_id` und `import_source` erweitert, um auch Adressdaten während des Imports abgleichen zu können.
