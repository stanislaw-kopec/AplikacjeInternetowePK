<?php

require_once 'Repository.php';

class SchemaRepository extends Repository {

    public function migrate(): void
    {
        $connection = $this->database->connect();

        $connection->exec("
            ALTER TABLE users
            ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'User' NOT NULL
        ");

        $connection->exec("
            ALTER TABLE specialists
            ADD COLUMN IF NOT EXISTS user_id INT UNIQUE,
            ADD COLUMN IF NOT EXISTS description TEXT DEFAULT '',
            ADD COLUMN IF NOT EXISTS bio TEXT DEFAULT '',
            ADD COLUMN IF NOT EXISTS avatar_url TEXT DEFAULT '',
            ADD COLUMN IF NOT EXISTS experience_years INT DEFAULT 0,
            ADD COLUMN IF NOT EXISTS response_time VARCHAR(50) DEFAULT '< 1 hour'
        ");

        $connection->exec("
            ALTER TABLE reviews
            ADD COLUMN IF NOT EXISTS user_id INT,
            ADD COLUMN IF NOT EXISTS created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
        ");

        // Nowa migracja – kategoria opinii
        $connection->exec("
            ALTER TABLE reviews
            ADD COLUMN IF NOT EXISTS user_id INT,
            ADD COLUMN IF NOT EXISTS created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
        ");

        // Bezpieczne dodanie kolumny category_id i klucza obcego
        $connection->exec("
            DO $$
            BEGIN
                -- Dodaj kolumnę, jeśli nie istnieje
                ALTER TABLE reviews ADD COLUMN IF NOT EXISTS category_id INT;

                -- Dodaj klucz obcy tylko jeśli jeszcze go nie ma
            IF NOT EXISTS (
            SELECT 1 FROM pg_constraint
            WHERE conname = 'fk_review_category'
              AND conrelid = 'reviews'::regclass
            ) THEN
            ALTER TABLE reviews ADD CONSTRAINT fk_review_category
                FOREIGN KEY (category_id) REFERENCES categories(id)
                ON DELETE SET NULL;
            END IF;
            END;
            $$;
        ");

        $connection->exec("
            CREATE TABLE IF NOT EXISTS categories (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) UNIQUE NOT NULL
            )
        ");

        $connection->exec("
            CREATE TABLE IF NOT EXISTS specialist_categories (
                specialist_id INT NOT NULL REFERENCES specialists(id) ON DELETE CASCADE,
                category_id INT NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
                PRIMARY KEY (specialist_id, category_id)
            )
        ");

        $connection->exec("
            CREATE TABLE IF NOT EXISTS portfolio_items (
                id SERIAL PRIMARY KEY,
                specialist_id INT NOT NULL REFERENCES specialists(id) ON DELETE CASCADE,
                title VARCHAR(150) NOT NULL,
                image_url TEXT NOT NULL
            )
        ");

        $connection->exec("
            INSERT INTO categories (name) VALUES
            ('Hydraulics'),
            ('Emergency'),
            ('Boilers'),
            ('Electrical'),
            ('Smart Home'),
            ('Renovation'),
            ('Diagnostics')
            ON CONFLICT (name) DO NOTHING
        ");

        $connection->exec("
            INSERT INTO locations (city)
            SELECT city
            FROM (VALUES ('Warszawa'), ('Krakow'), ('Gdansk')) AS seed(city)
            WHERE NOT EXISTS (
                SELECT 1 FROM locations WHERE locations.city = seed.city
            )
        ");

        $connection->exec("
            UPDATE specialists
            SET description = CASE
                    WHEN profession ILIKE '%hydraulik%' THEN 'Master plumber with experience in heating, leaks and urgent repairs.'
                    WHEN profession ILIKE '%elektryk%' THEN 'Certified electrician focused on installations, diagnostics and smart systems.'
                    ELSE 'Reliable local professional ready to help with home projects.'
                END,
                bio = CASE
                    WHEN bio = '' OR bio IS NULL THEN 'Tell clients about your experience, services and working style.'
                    ELSE bio
                END,
                response_time = CASE
                    WHEN response_time = '' OR response_time IS NULL THEN '< 1 hour'
                    ELSE response_time
                END
            WHERE description = '' OR description IS NULL
        ");

        $connection->exec("
            INSERT INTO specialist_locations (specialist_id, location_id)
            SELECT s.id, l.id
            FROM specialists s
            CROSS JOIN locations l
            WHERE l.city = 'Warszawa'
            ON CONFLICT (specialist_id, location_id) DO NOTHING
        ");

        $connection->exec("
            INSERT INTO specialist_categories (specialist_id, category_id)
            SELECT s.id, c.id
            FROM specialists s
            JOIN categories c ON (
                (s.profession ILIKE '%hydraulik%' AND c.name IN ('Hydraulics', 'Emergency')) OR
                (s.profession ILIKE '%elektryk%' AND c.name IN ('Electrical', 'Smart Home')) OR
                (s.profession NOT ILIKE '%hydraulik%' AND s.profession NOT ILIKE '%elektryk%' AND c.name IN ('Renovation', 'Diagnostics'))
            )
            ON CONFLICT (specialist_id, category_id) DO NOTHING
        ");
    }
}