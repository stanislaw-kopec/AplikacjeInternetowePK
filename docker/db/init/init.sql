/*
CREATE TABLE users (
    -- Klucz główny generowany automatycznie
    id SERIAL PRIMARY KEY,
    
    -- Dane użytkownika z podstawową walidacją
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password TEXT NOT NULL,
    
    -- Opcjonalne pole profilowe
    full_name VARCHAR(100),
    
    -- Metadane systemowe
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
*/

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE profiles (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    username VARCHAR(100) NOT NULL,

    CONSTRAINT fk_profile_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE specialists (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    profession VARCHAR(100) NOT NULL
);

CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    specialist_id INT NOT NULL,
    author VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    comment TEXT,

    CONSTRAINT fk_review_specialist
        FOREIGN KEY (specialist_id)
        REFERENCES specialists(id)
        ON DELETE CASCADE
);

CREATE TABLE locations (
    id SERIAL PRIMARY KEY,
    city VARCHAR(100) NOT NULL
);

CREATE TABLE specialist_locations (
    specialist_id INT NOT NULL,
    location_id INT NOT NULL,

    PRIMARY KEY (specialist_id, location_id),

    CONSTRAINT fk_specialist
        FOREIGN KEY (specialist_id)
        REFERENCES specialists(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_location
        FOREIGN KEY (location_id)
        REFERENCES locations(id)
        ON DELETE CASCADE
);