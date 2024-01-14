<?php

define('BASE_DIR', dirname(__DIR__));

require_once BASE_DIR . '/config/constants.php';
require_once BASE_DIR . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(BASE_DIR);
$dotenv->load();

class Migration
{
    const SCRIPTS_DIR = __DIR__ . '/scripts/';
    const MIGRATION_FILE = '0_migrations';

    protected PDO $db;

    public function __construct()
    {
        $this->db = db();

        try{
            $this->db->beginTransaction();

            $this->createMigrationTable();
            $this->runMigrations();

            if ($this->db->inTransaction()){
                $this->db->commit();
            }
        }catch(PDOException $e){
            d($e->getMessage(), $e->getTrace());
            if($this->db->inTransaction()){
                $this->db->rollBack();
            }
        }
    }

    protected function runMigrations(): void
    {
        d('---- Fetching migrations ----');

        $migrations = scandir(static::SCRIPTS_DIR);
        $migrations = array_values(array_diff(
            $migrations,
            ['.', '..', static::MIGRATION_FILE . '.sql']
        ));

        foreach ($migrations as $migration){
            $table = preg_replace('/[\d]+_/i', '', $migration);
        }

        d('---- Migrations done! ----');
    }

    protected function createMigrationTable(): void
    {
        d('---- Prepare migration table query ----');

        $sql = file_get_contents(static::SCRIPTS_DIR . static::MIGRATION_FILE . '.sql');
        $query = $this->db->prepare($sql);

        $result = match($query->execute())
        {
            true => '- Migration table was created (or already exists)',
            false => '-Failed'
        };
        d($result, '---- Finished migration table query ----');
    }
}new Migration();