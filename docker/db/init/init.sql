CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'User' NOT NULL
);

CREATE TABLE profiles (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    username VARCHAR(100) NOT NULL,
    CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE specialists (
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

CREATE TABLE reviews (
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

CREATE TABLE locations (
    id SERIAL PRIMARY KEY,
    city VARCHAR(100) NOT NULL
);

CREATE TABLE specialist_locations (
    specialist_id INT NOT NULL,
    location_id INT NOT NULL,
    PRIMARY KEY (specialist_id, location_id),
    CONSTRAINT fk_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE,
    CONSTRAINT fk_location FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE CASCADE
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE specialist_categories (
    specialist_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (specialist_id, category_id),
    CONSTRAINT fk_specialist_category_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE,
    CONSTRAINT fk_specialist_category_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE portfolio_items (
    id SERIAL PRIMARY KEY,
    specialist_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    image_url TEXT NOT NULL,
    CONSTRAINT fk_portfolio_specialist FOREIGN KEY (specialist_id) REFERENCES specialists(id) ON DELETE CASCADE
);

INSERT INTO locations (city) VALUES
('Warszawa'),
('Krakow'),
('Gdansk');

INSERT INTO categories (name) VALUES
('Hydraulics'),
('Emergency'),
('Boilers'),
('Electrical'),
('Smart Home'),
('Renovation'),
('Diagnostics');

INSERT INTO specialists (name, profession, phone, description, bio, avatar_url, experience_years, response_time) VALUES
('Adam Kowalski', 'Hydraulik', '+48 601 234 567', 'Master plumber with 15 years of experience in central heating and complex leak detections.', 'I specialize in central heating, leak detection and urgent home repairs. My work is based on clear communication and tidy execution.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g', 15, '< 1 hour'),
('Marek Wisniewski', 'Elektryk', '+48 602 345 678', 'Specializing in modern electrical installations and eco-friendly energy systems.', 'Certified electrician focused on home installations, diagnostics and smart systems.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM', 10, '< 2 hours'),
('Anna Nowak', 'Tynkarz', '+48 603 456 789', 'Expert in renovation finishing, wall diagnostics and precision repair.', 'I help clients finish renovation work with reliable timelines and clean finishing.', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDFIWhc6vux3lu4GUu1hUArTZpfu5p_lWHApRoRQJ8_zYPtOr97DChRYuJiy6vYI-keZHl7g8nDzGEDk_NST4i0Lo6ESNnkJ4WXyk-JI41v4XWk_SUYSR_c0zlqDVTJLxySsK7fuXVqwMkE-O-54hDuP5bkApWygN3IrLPk3oHVxk43fJZMkhB73CXo7qmKilnzzG07veMZDUqbgGQ8o4l9AkQGl9gq_J4TrUkqLjXghPZezD0ISrkxooHrkwa-1iE8JRBUG5PbqT4', 8, '< 1 day');

INSERT INTO specialist_locations (specialist_id, location_id) VALUES
(1, 1),
(2, 1),
(3, 1);

INSERT INTO specialist_categories (specialist_id, category_id) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7);

INSERT INTO portfolio_items (specialist_id, title, image_url) VALUES
(1, 'Bathroom Renovation', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE'),
(1, 'System Upgrade', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7CtfErB0_GbLkSaXj3QKDy_1k0ak6O01w4FAAzLf2ymXA4BImJj_qUb6pem2dIA_iDrpSDdFj3eZPv4COEwvVGbx6TAiRxHNH3e16xBCy2fEPPkLjfhfG2kFKJfqAN5fVkmROLnrx5D7ricNmhMHGdQOU6y3qBlgiJMTbDwRXHMJmEZblMV8Tn_JSZ4poIFgr4QJpp90EO_AbFvTbibLRE7V-0M9JC1feiusuydhtnQgDRu1eMS4P4zLREl_FTfXm5yjQzJrk7qk');