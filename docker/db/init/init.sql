-- =====================================================
-- 1. Wyczyszczenie starych danych (opcjonalne)
--    Odkomentuj, jeśli chcesz zacząć od zera
-- =====================================================
/*
TRUNCATE TABLE reviews CASCADE;
TRUNCATE TABLE portfolio_items CASCADE;
TRUNCATE TABLE specialist_categories CASCADE;
TRUNCATE TABLE specialist_locations CASCADE;
TRUNCATE TABLE specialists CASCADE;
TRUNCATE TABLE profiles CASCADE;
TRUNCATE TABLE users CASCADE;
TRUNCATE TABLE categories CASCADE;
TRUNCATE TABLE locations CASCADE;
*/

-- =====================================================
-- 2. Tabele
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'User' NOT NULL
);

CREATE TABLE IF NOT EXISTS profiles (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    username VARCHAR(100) NOT NULL,
    CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS specialists (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE,
    name VARCHAR(100) NOT NULL,
    profession VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    description TEXT DEFAULT '',
    bio TEXT DEFAULT '',
    avatar_url TEXT DEFAULT '',
    experience_years INT DEFAULT 0,
    response_time VARCHAR(50) DEFAULT '< 1 hour',
    CONSTRAINT fk_specialist_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reviews (
    id SERIAL PRIMARY KEY,
    specialist_id INT NOT NULL,
    user_id INT,
    author VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_review_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE,
    CONSTRAINT fk_review_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS locations (
    id SERIAL PRIMARY KEY,
    city VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS specialist_locations (
    specialist_id INT NOT NULL,
    location_id INT NOT NULL,
    PRIMARY KEY (specialist_id, location_id),
    CONSTRAINT fk_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE,
    CONSTRAINT fk_location FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS specialist_categories (
    specialist_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (specialist_id, category_id),
    CONSTRAINT fk_specialist_category_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE,
    CONSTRAINT fk_specialist_category_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS portfolio_items (
    id SERIAL PRIMARY KEY,
    specialist_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    image_url TEXT NOT NULL,
    CONSTRAINT fk_portfolio_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE
);

-- =====================================================
-- 3. Dane podstawowe (lokalizacje, kategorie)
-- =====================================================
INSERT INTO locations (city) VALUES
('Warszawa'),
('Kraków'),
('Gdańsk'),
('Wrocław'),
('Poznań');

INSERT INTO categories (name) VALUES
('Hydraulics'),
('Emergency'),
('Boilers'),
('Electrical'),
('Smart Home'),
('Renovation'),
('Diagnostics')
ON CONFLICT (name) DO NOTHING;   -- tu jest OK, bo name jest UNIQUE

-- =====================================================
-- 4. Użytkownicy (hasło: password123)
-- =====================================================
INSERT INTO users (id, email, password, role) VALUES
(1, 'jan.kowalski@example.com', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'User'),
(2, 'anna.nowak@example.com', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'User'),
(3, 'krzysztof.borys@example.com', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'User'),
(4, 'adam.kowalski@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist'),
(5, 'marek.wisniewski@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist'),
(6, 'ewa.kaminska@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist'),
(7, 'piotr.zielinski@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist'),
(8, 'magdalena.wilk@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist'),
(9, 'tomasz.krol@pro.pl', '$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy', 'Specialist')
ON CONFLICT (email) DO NOTHING;

-- Profile
INSERT INTO profiles (user_id, username) VALUES
(1, 'JanKowalski'),
(2, 'AnnaNowak'),
(3, 'KrzysztofBorys'),
(4, 'AdamK'),
(5, 'MarekElektryk'),
(6, 'EwaKaminska'),
(7, 'PiotrZielinski'),
(8, 'MagdaWilk'),
(9, 'TomaszKrol')
ON CONFLICT (user_id) DO NOTHING;

-- =====================================================
-- 5. Specjaliści
-- =====================================================
INSERT INTO specialists (id, user_id, name, profession, phone, description, bio, avatar_url, experience_years, response_time) VALUES
(1, 4, 'Adam Kowalski', 'Hydraulik', '+48 601 234 567', 'Master plumber with 15 years of experience...', 'I specialize in central heating, leak detection...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g', 15, '< 1 hour'),
(2, 5, 'Marek Wiśniewski', 'Elektryk', '+48 602 345 678', 'Specializing in modern electrical installations...', 'Certified electrician focused on home installations...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM', 10, '< 2 hours'),
(3, NULL, 'Anna Nowak', 'Tynkarz', '+48 603 456 789', 'Expert in renovation finishing...', 'I help clients finish renovation work...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFIWhc6vux3lu4GUu1hUArTZpfu5p_lWHApRoRQJ8_zYPtOr97DChRYuJiy6vYI-keZHl7g8nDzGEDk_NST4i0Lo6ESNnkJ4WXyk-JI41v4XWk_SUYSR_c0zlqDVTJLxySsK7fuXVqwMkE-O-54hDuP5bkApWygN3IrLPk3oHVxk43fJZMkhB73CXo7qmKilnzzG07veMZDUqbgGQ8o4l9AkQGl9gq_J4TrUkqLjXghPZezD0ISrkxooHrkwa-1iE8JRBUG5PbqT4', 8, '< 1 day'),
(4, 6, 'Ewa Kamińska', 'Malarz', '+48 604 567 890', 'Professional painter with an eye for detail...', 'I specialize in interior and exterior painting...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBV8x1HwXu0lz_aJxRmXsI3uT1yXRGkqKjFQnLhUcGvT9sVQOAKZ9pBzF4f1h1eO-2St3yF06cHgwHzf8j', 12, '< 3 hours'),
(5, 7, 'Piotr Zieliński', 'Stolarz', '+48 605 678 901', 'Custom woodwork and furniture restoration...', 'I craft bespoke furniture...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE', 20, '< 1 day'),
(6, 8, 'Magdalena Wilk', 'Glazurnik', '+48 606 789 012', 'Expert tiler transforming bathrooms...', 'I ensure every tile is perfectly aligned...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM', 7, '< 1 hour'),
(7, 9, 'Tomasz Król', 'Złota rączka', '+48 607 890 123', 'All-around handyman for minor repairs...', 'No job too small...', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g', 5, '< 2 hours')
ON CONFLICT (id) DO NOTHING;

-- =====================================================
-- 6. Powiązania specjaliści – lokalizacje
-- =====================================================
INSERT INTO specialist_locations (specialist_id, location_id) VALUES
(1, 1), (2, 1), (2, 2), (3, 1), (3, 4),
(4, 2), (4, 5), (5, 3), (6, 4), (6, 5), (7, 1), (7, 2), (7, 3)
ON CONFLICT (specialist_id, location_id) DO NOTHING;

-- =====================================================
-- 7. Powiązania specjaliści – kategorie
-- =====================================================
INSERT INTO specialist_categories (specialist_id, category_id) VALUES
(1, 1), (1, 2), (1, 3), (2, 4), (2, 5), (2, 7),
(3, 6), (3, 7), (4, 6), (5, 6), (5, 7), (6, 6), (7, 1), (7, 2), (7, 4)
ON CONFLICT (specialist_id, category_id) DO NOTHING;

-- =====================================================
-- 8. Portfolio
-- =====================================================
INSERT INTO portfolio_items (specialist_id, title, image_url) VALUES
(1, 'Modern Bathroom Renovation', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE'),
(1, 'Central Heating Installation', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7CtfErB0_GbLkSaXj3QKDy_1k0ak6O01w4FAAzLf2ymXA4BImJj_qUb6pem2dIA_iDrpSDdFj3eZPv4COEwvVGbx6TAiRxHNH3e16xBCy2fEPPkLjfhfG2kFKJfqAN5fVkmROLnrx5D7ricNmhMHGdQOU6y3qBlgiJMTbDwRXHMJmEZblMV8Tn_JSZ4poIFgr4QJpp90EO_AbFvTbibLRE7V-0M9JC1feiusuydhtnQgDRu1eMS4P4zLREl_FTfXm5yjQzJrk7qk'),
(2, 'Smart Home Panel Upgrade', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7CtfErB0_GbLkSaXj3QKDy_1k0ak6O01w4FAAzLf2ymXA4BImJj_qUb6pem2dIA_iDrpSDdFj3eZPv4COEwvVGbx6TAiRxHNH3e16xBCy2fEPPkLjfhfG2kFKJfqAN5fVkmROLnrx5D7ricNmhMHGdQOU6y3qBlgiJMTbDwRXHMJmEZblMV8Tn_JSZ4poIFgr4QJpp90EO_AbFvTbibLRE7V-0M9JC1feiusuydhtnQgDRu1eMS4P4zLREl_FTfXm5yjQzJrk7qk'),
(3, 'Living Room Wall Restoration', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFIWhc6vux3lu4GUu1hUArTZpfu5p_lWHApRoRQJ8_zYPtOr97DChRYuJiy6vYI-keZHl7g8nDzGEDk_NST4i0Lo6ESNnkJ4WXyk-JI41v4XWk_SUYSR_c0zlqDVTJLxySsK7fuXVqwMkE-O-54hDuP5bkApWygN3IrLPk3oHVxk43fJZMkhB73CXo7qmKilnzzG07veMZDUqbgGQ8o4l9AkQGl9gq_J4TrUkqLjXghPZezD0ISrkxooHrkwa-1iE8JRBUG5PbqT4'),
(4, 'Bedroom Mural Project', 'https://lh3.googleusercontent.com/aida-public/AB6AXuBV8x1HwXu0lz_aJxRmXsI3uT1yXRGkqKjFQnLhUcGvT9sVQOAKZ9pBzF4f1h1eO-2St3yF06cHgwHzf8j'),
(5, 'Custom Oak Desk', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE'),
(6, 'Kitchen Tiles', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM'),
(7, 'Faucet Replacement', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g');

-- =====================================================
-- 9. Opinie
-- =====================================================
INSERT INTO reviews (specialist_id, user_id, author, rating, comment, created_at) VALUES
(1, 1, 'Jan Kowalski', 5, 'Szybko i fachowo. Pan Adam uratował moją łazienkę przed zalaniem.', '2025-05-10 14:30:00+02'),
(1, 2, 'Anna Nowak', 4, 'Bardzo dobry hydraulik, czysta robota.', '2025-04-22 09:15:00+02'),
(2, 3, 'Krzysztof Borys', 5, 'Inteligentny dom działa bez zarzutu. Polecam!', '2025-06-01 11:00:00+02'),
(2, 1, 'Jan Kowalski', 4, 'Solidna instalacja elektryczna, terminowo.', '2025-03-15 16:45:00+01'),
(3, 2, 'Anna Nowak', 5, 'Piękne wykończenie ścian, brak zastrzeżeń.', '2025-05-28 08:20:00+02'),
(4, 3, 'Krzysztof Borys', 4, 'Ewa pomalowała pokój idealnie.', '2025-06-10 13:10:00+02'),
(5, 1, 'Jan Kowalski', 5, 'Stół na wymiar – mistrzostwo!', '2025-04-05 10:00:00+02'),
(6, 2, 'Anna Nowak', 5, 'Kafelki w łazience ułożone perfekcyjnie.', '2025-06-12 12:30:00+02'),
(7, 3, 'Krzysztof Borys', 4, 'Złota rączka – wymienił kran i gniazdka w godzinę.', '2025-05-20 17:00:00+02'),
(7, 1, 'Jan Kowalski', 3, 'Wszystko ok, ale trochę za drogo.', '2025-06-15 09:00:00+02');