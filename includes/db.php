<?php
class DB
{
    private static $instance = null;
    private ?PDO $dbh;
    private bool $connected = false;
    private string $sqlFile = "./escalada.sql";

    /**
     * Constructor privat (Singelton)
     */
    private function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=escalada', "root", "patata2");
            $this->generateDatabase();
            $this->connected = true;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function generateDatabase(): void
    {
        try {
            $this->dbh->exec("CREATE DATABASE IF NOT EXISTS escalada");
            $this->dbh->exec("USE escalada");

            $tableExists = $this->isTableExists('escalada');
            if (!$tableExists) {
                $sql = file_get_contents($this->sqlFile);
                $this->dbh->exec($sql);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function isTableExists(string $tableName): bool
    {
        try {
            $query = "SHOW TABLES LIKE '$tableName'";
            $result = $this->dbh->query($query);
            return $result && $result->rowCount() > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }



    /**
     * Mètode per agafar la instància sempre activa (Singelton)
     * @return DB
     */
    public static function get_instance(): DB
    {
        if (self::$instance == null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    /**
     * Comprova la connexió amb la base de dades.
     * @return bool
     */
    public function connected(): bool
    {
        return $this->connected;
    }

    public function add_participant(mixed $nom, mixed $cognom, mixed $email): bool
    {
        try {
            $stmt = $this->dbh->prepare("INSERT INTO participant (nom, cognom, email) VALUES (:nom, :cognom, :email)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':cognom', $cognom);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function eliminar_assoliments(): void
    {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM assoliment");
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function eliminar_participants()
    {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM participant");
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function eliminar_vies_sectors()
    {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM sector");
            $stmt->execute();
            $stmt = $this->dbh->prepare("DELETE FROM via");
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
    // nom : Rollo Love
    // sector : Collegats - La pedrera
    // grau : 8
    private $vies = array(
        ["nom" => "Rollo Love", "sector" => "Collegats - La pedrera", "grau" => 8],
        ["nom" => "Rollo Javalí", "sector" => "Collegats - La pedrera", "grau" => 9],
        ["nom" => "Bioactiva", "sector" => "Collegats - La pedrera", "grau" => 3],
        ["nom" => "L’arcada del dimoni", "sector" => "Sadernes - El diable", "grau" => 6],
        ["nom" => "Bruixots", "sector" => "Sadernes - El diable", "grau" => 5],
    );

    private $sectors = array(
        ["nom" => "Collegats - La pedrera"],
        ["nom" => "Sadernes - El diable"]
    );

    public function generar_vies_sectors()
    {
        // Primer insertem els sectors
        try {
            foreach ($this->sectors as $sector) {
                $stmt = $this->dbh->prepare("INSERT INTO sector (nom) VALUES (:nom)");
                $stmt->bindParam(':nom', $sector["nom"]);
                $stmt->execute();
            }

            // Ara insertem les vies
            foreach ($this->vies as $via) {
                $stmt = $this->dbh->prepare("INSERT INTO via (nom, grau, sector) VALUES (:nom, :grau, :sector)");
                $stmt->bindParam(':nom', $via["nom"]);
                $stmt->bindParam(':grau', $via["grau"]);
                $stmt->bindParam(':sector', $via["sector"]);
                $stmt->execute();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
    /**
     * Retorna un array amb el nom i cognom dels participants
     * @return array
     */
    public function get_participants()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM participant");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function get_vies()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM via");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function afegir_assoliment(mixed $participant, mixed $via, mixed $data, mixed $encadenat, mixed $primer, mixed $assegurador)
    {
        try {
            $intent = $this->get_number_intents($participant, $via);
            $stmt = $this->dbh->prepare("INSERT INTO assoliment (participant, via, intent, data, encadenat, primer, assegurador) VALUES (:participant, :via, :intent, :data, :encadenat, :primer, :assegurador)");
            $stmt->bindParam(':participant', $participant);
            $stmt->bindParam(':via', $via);
            $stmt->bindParam(':intent', $intent);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':encadenat', $encadenat);
            $stmt->bindParam(':primer', $primer);
            $stmt->bindParam(':assegurador', $assegurador);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function get_assoliments_participants(): bool|array
    {
        try {
            // We want for each participant their latest achievement
            // So we will select the maximum (latest) intent for each participant
            // We also need to get the name and the surname of the participant
            // And the grau of the via
            $stmt = $this->dbh->prepare("
            SELECT participant.nom, participant.cognom, via.grau, assoliment.*
            FROM assoliment 
            INNER JOIN participant ON assoliment.participant = participant.email
            INNER JOIN via ON assoliment.via = via.nom
            WHERE assoliment.intent = (
                SELECT MAX(intent)
                FROM assoliment AS a
                WHERE a.participant = assoliment.participant
            )
            ORDER BY participant.nom");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }



    private function get_number_intents(mixed $participant, mixed $via)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM assoliment WHERE participant = :participant AND via = :via");
            $stmt->bindParam(':participant', $participant);
            $stmt->bindParam(':via', $via);
            $stmt->execute();
            return $stmt->rowCount() + 1;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function get_top_dificultat()
    {
        // We want to get the achievement with the highest difficulty of the via
        // So we need to select achivement with inner join with via, order by grau
        // We also need to inner join participant to get the name and the surname

        try {
            $stmt = $this->dbh->prepare(
                "SELECT participant.nom, participant.cognom, via.grau, assoliment.* FROM assoliment 
                        INNER JOIN participant ON assoliment.participant = participant.email
                        INNER JOIN via ON assoliment.via = via.nom 
                        ORDER BY grau DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function get_participants_with_more_vies()
    {
        // We will return the top 10 participants with more achievements with different vies
        // We also need to inner join participant to get the name and the surname and the number of achievements
        try {
            $stmt = $this->dbh->prepare(
                "SELECT participant.nom, participant.cognom, COUNT(DISTINCT assoliment.via) AS num_assoliments FROM assoliment 
                        INNER JOIN participant ON assoliment.participant = participant.email
                        GROUP BY assoliment.participant ORDER BY num_assoliments DESC LIMIT 10");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}
