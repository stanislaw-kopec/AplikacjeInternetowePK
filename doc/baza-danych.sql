--
-- PostgreSQL database dump
--

\restrict gWqeyuhaA4RvAjkcvHGffzohZfh1SVdfIqZ03Zpj9bUzA9g0OQeengFMM06vwKg

-- Dumped from database version 15.18
-- Dumped by pg_dump version 15.17

-- Started on 2026-05-27 16:37:11 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 226 (class 1259 OID 16475)
-- Name: categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.categories OWNER TO docker;

--
-- TOC entry 225 (class 1259 OID 16474)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categories_id_seq OWNER TO docker;

--
-- TOC entry 3510 (class 0 OID 0)
-- Dependencies: 225
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 223 (class 1259 OID 16453)
-- Name: locations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.locations (
    id integer NOT NULL,
    city character varying(100) NOT NULL
);


ALTER TABLE public.locations OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16452)
-- Name: locations_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.locations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.locations_id_seq OWNER TO docker;

--
-- TOC entry 3511 (class 0 OID 0)
-- Dependencies: 222
-- Name: locations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.locations_id_seq OWNED BY public.locations.id;


--
-- TOC entry 229 (class 1259 OID 16499)
-- Name: portfolio_items; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.portfolio_items (
    id integer NOT NULL,
    specialist_id integer NOT NULL,
    title character varying(150) NOT NULL,
    image_url text NOT NULL
);


ALTER TABLE public.portfolio_items OWNER TO docker;

--
-- TOC entry 228 (class 1259 OID 16498)
-- Name: portfolio_items_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.portfolio_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.portfolio_items_id_seq OWNER TO docker;

--
-- TOC entry 3512 (class 0 OID 0)
-- Dependencies: 228
-- Name: portfolio_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.portfolio_items_id_seq OWNED BY public.portfolio_items.id;


--
-- TOC entry 217 (class 1259 OID 16398)
-- Name: profiles; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.profiles (
    id integer NOT NULL,
    user_id integer NOT NULL,
    username character varying(100) NOT NULL
);


ALTER TABLE public.profiles OWNER TO docker;

--
-- TOC entry 216 (class 1259 OID 16397)
-- Name: profiles_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.profiles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profiles_id_seq OWNER TO docker;

--
-- TOC entry 3513 (class 0 OID 0)
-- Dependencies: 216
-- Name: profiles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.profiles_id_seq OWNED BY public.profiles.id;


--
-- TOC entry 221 (class 1259 OID 16433)
-- Name: reviews; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.reviews (
    id integer NOT NULL,
    specialist_id integer NOT NULL,
    user_id integer,
    author character varying(100) NOT NULL,
    rating integer NOT NULL,
    comment text,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.reviews OWNER TO docker;

--
-- TOC entry 220 (class 1259 OID 16432)
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reviews_id_seq OWNER TO docker;

--
-- TOC entry 3514 (class 0 OID 0)
-- Dependencies: 220
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- TOC entry 227 (class 1259 OID 16483)
-- Name: specialist_categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.specialist_categories (
    specialist_id integer NOT NULL,
    category_id integer NOT NULL
);


ALTER TABLE public.specialist_categories OWNER TO docker;

--
-- TOC entry 224 (class 1259 OID 16459)
-- Name: specialist_locations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.specialist_locations (
    specialist_id integer NOT NULL,
    location_id integer NOT NULL
);


ALTER TABLE public.specialist_locations OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16412)
-- Name: specialists; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.specialists (
    id integer NOT NULL,
    user_id integer,
    name character varying(100) NOT NULL,
    profession character varying(100) NOT NULL,
    phone character varying(20) NOT NULL,
    description text DEFAULT ''::text,
    bio text DEFAULT ''::text,
    avatar_url text DEFAULT ''::text,
    experience_years integer DEFAULT 0,
    response_time character varying(50) DEFAULT '< 1 hour'::character varying
);


ALTER TABLE public.specialists OWNER TO docker;

--
-- TOC entry 218 (class 1259 OID 16411)
-- Name: specialists_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.specialists_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.specialists_id_seq OWNER TO docker;

--
-- TOC entry 3515 (class 0 OID 0)
-- Dependencies: 218
-- Name: specialists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.specialists_id_seq OWNED BY public.specialists.id;


--
-- TOC entry 215 (class 1259 OID 16386)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(50) DEFAULT 'User'::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 214 (class 1259 OID 16385)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO docker;

--
-- TOC entry 3516 (class 0 OID 0)
-- Dependencies: 214
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 3310 (class 2604 OID 16478)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 3309 (class 2604 OID 16456)
-- Name: locations id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.locations ALTER COLUMN id SET DEFAULT nextval('public.locations_id_seq'::regclass);


--
-- TOC entry 3311 (class 2604 OID 16502)
-- Name: portfolio_items id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.portfolio_items ALTER COLUMN id SET DEFAULT nextval('public.portfolio_items_id_seq'::regclass);


--
-- TOC entry 3300 (class 2604 OID 16401)
-- Name: profiles id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.profiles ALTER COLUMN id SET DEFAULT nextval('public.profiles_id_seq'::regclass);


--
-- TOC entry 3307 (class 2604 OID 16436)
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- TOC entry 3301 (class 2604 OID 16415)
-- Name: specialists id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialists ALTER COLUMN id SET DEFAULT nextval('public.specialists_id_seq'::regclass);


--
-- TOC entry 3298 (class 2604 OID 16389)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3501 (class 0 OID 16475)
-- Dependencies: 226
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.categories (id, name) FROM stdin;
1	Hydraulics
2	Emergency
3	Boilers
4	Electrical
5	Smart Home
6	Renovation
7	Diagnostics
\.


--
-- TOC entry 3498 (class 0 OID 16453)
-- Dependencies: 223
-- Data for Name: locations; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.locations (id, city) FROM stdin;
1	Warszawa
2	Kraków
3	Gdańsk
4	Wrocław
5	Poznań
6	Krakow
7	Gdansk
\.


--
-- TOC entry 3504 (class 0 OID 16499)
-- Dependencies: 229
-- Data for Name: portfolio_items; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.portfolio_items (id, specialist_id, title, image_url) FROM stdin;
1	1	Modern Bathroom Renovation	https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE
2	1	Central Heating Installation	https://lh3.googleusercontent.com/aida-public/AB6AXuC7CtfErB0_GbLkSaXj3QKDy_1k0ak6O01w4FAAzLf2ymXA4BImJj_qUb6pem2dIA_iDrpSDdFj3eZPv4COEwvVGbx6TAiRxHNH3e16xBCy2fEPPkLjfhfG2kFKJfqAN5fVkmROLnrx5D7ricNmhMHGdQOU6y3qBlgiJMTbDwRXHMJmEZblMV8Tn_JSZ4poIFgr4QJpp90EO_AbFvTbibLRE7V-0M9JC1feiusuydhtnQgDRu1eMS4P4zLREl_FTfXm5yjQzJrk7qk
3	2	Smart Home Panel Upgrade	https://lh3.googleusercontent.com/aida-public/AB6AXuC7CtfErB0_GbLkSaXj3QKDy_1k0ak6O01w4FAAzLf2ymXA4BImJj_qUb6pem2dIA_iDrpSDdFj3eZPv4COEwvVGbx6TAiRxHNH3e16xBCy2fEPPkLjfhfG2kFKJfqAN5fVkmROLnrx5D7ricNmhMHGdQOU6y3qBlgiJMTbDwRXHMJmEZblMV8Tn_JSZ4poIFgr4QJpp90EO_AbFvTbibLRE7V-0M9JC1feiusuydhtnQgDRu1eMS4P4zLREl_FTfXm5yjQzJrk7qk
4	3	Living Room Wall Restoration	https://lh3.googleusercontent.com/aida-public/AB6AXuDFIWhc6vux3lu4GUu1hUArTZpfu5p_lWHApRoRQJ8_zYPtOr97DChRYuJiy6vYI-keZHl7g8nDzGEDk_NST4i0Lo6ESNnkJ4WXyk-JI41v4XWk_SUYSR_c0zlqDVTJLxySsK7fuXVqwMkE-O-54hDuP5bkApWygN3IrLPk3oHVxk43fJZMkhB73CXo7qmKilnzzG07veMZDUqbgGQ8o4l9AkQGl9gq_J4TrUkqLjXghPZezD0ISrkxooHrkwa-1iE8JRBUG5PbqT4
5	4	Bedroom Mural Project	https://lh3.googleusercontent.com/aida-public/AB6AXuBV8x1HwXu0lz_aJxRmXsI3uT1yXRGkqKjFQnLhUcGvT9sVQOAKZ9pBzF4f1h1eO-2St3yF06cHgwHzf8j
6	5	Custom Oak Desk	https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE
7	6	Kitchen Tiles	https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM
8	7	Faucet Replacement	https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g
\.


--
-- TOC entry 3492 (class 0 OID 16398)
-- Dependencies: 217
-- Data for Name: profiles; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.profiles (id, user_id, username) FROM stdin;
1	1	JanKowalski
2	2	AnnaNowak
3	3	KrzysztofBorys
4	4	AdamK
5	5	MarekElektryk
6	6	EwaKaminska
7	7	PiotrZielinski
8	8	MagdaWilk
9	9	TomaszKrol
10	10	AnnaKowalska
11	11	Mario
\.


--
-- TOC entry 3496 (class 0 OID 16433)
-- Dependencies: 221
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.reviews (id, specialist_id, user_id, author, rating, comment, created_at) FROM stdin;
1	1	1	Jan Kowalski	5	Szybko i fachowo. Pan Adam uratował moją łazienkę przed zalaniem.	2025-05-10 12:30:00+00
2	1	2	Anna Nowak	4	Bardzo dobry hydraulik, czysta robota.	2025-04-22 07:15:00+00
3	2	3	Krzysztof Borys	5	Inteligentny dom działa bez zarzutu. Polecam!	2025-06-01 09:00:00+00
4	2	1	Jan Kowalski	4	Solidna instalacja elektryczna, terminowo.	2025-03-15 15:45:00+00
5	3	2	Anna Nowak	5	Piękne wykończenie ścian, brak zastrzeżeń.	2025-05-28 06:20:00+00
6	4	3	Krzysztof Borys	4	Ewa pomalowała pokój idealnie.	2025-06-10 11:10:00+00
7	5	1	Jan Kowalski	5	Stół na wymiar – mistrzostwo!	2025-04-05 08:00:00+00
8	6	2	Anna Nowak	5	Kafelki w łazience ułożone perfekcyjnie.	2025-06-12 10:30:00+00
9	7	3	Krzysztof Borys	4	Złota rączka – wymienił kran i gniazdka w godzinę.	2025-05-20 15:00:00+00
10	7	1	Jan Kowalski	3	Wszystko ok, ale trochę za drogo.	2025-06-15 07:00:00+00
11	1	10	AnnaKowalska@gmail.com	4	Dobra robota	2026-05-27 16:17:05.691943+00
\.


--
-- TOC entry 3502 (class 0 OID 16483)
-- Dependencies: 227
-- Data for Name: specialist_categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.specialist_categories (specialist_id, category_id) FROM stdin;
1	1
1	2
1	3
2	4
2	5
2	7
3	6
3	7
4	6
5	6
5	7
6	6
7	1
7	2
7	4
4	7
6	7
7	6
7	7
8	7
8	6
\.


--
-- TOC entry 3499 (class 0 OID 16459)
-- Dependencies: 224
-- Data for Name: specialist_locations; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.specialist_locations (specialist_id, location_id) FROM stdin;
1	1
2	1
2	2
3	1
3	4
4	2
4	5
5	3
6	4
6	5
7	1
7	2
7	3
4	1
5	1
6	1
8	1
\.


--
-- TOC entry 3494 (class 0 OID 16412)
-- Dependencies: 219
-- Data for Name: specialists; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.specialists (id, user_id, name, profession, phone, description, bio, avatar_url, experience_years, response_time) FROM stdin;
1	4	Adam Kowalski	Hydraulik	+48 601 234 567	Master plumber with 15 years of experience...	I specialize in central heating, leak detection...	https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g	15	< 1 hour
2	5	Marek Wiśniewski	Elektryk	+48 602 345 678	Specializing in modern electrical installations...	Certified electrician focused on home installations...	https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM	10	< 2 hours
3	\N	Anna Nowak	Tynkarz	+48 603 456 789	Expert in renovation finishing...	I help clients finish renovation work...	https://lh3.googleusercontent.com/aida-public/AB6AXuDFIWhc6vux3lu4GUu1hUArTZpfu5p_lWHApRoRQJ8_zYPtOr97DChRYuJiy6vYI-keZHl7g8nDzGEDk_NST4i0Lo6ESNnkJ4WXyk-JI41v4XWk_SUYSR_c0zlqDVTJLxySsK7fuXVqwMkE-O-54hDuP5bkApWygN3IrLPk3oHVxk43fJZMkhB73CXo7qmKilnzzG07veMZDUqbgGQ8o4l9AkQGl9gq_J4TrUkqLjXghPZezD0ISrkxooHrkwa-1iE8JRBUG5PbqT4	8	< 1 day
4	6	Ewa Kamińska	Malarz	+48 604 567 890	Professional painter with an eye for detail...	I specialize in interior and exterior painting...	https://lh3.googleusercontent.com/aida-public/AB6AXuBV8x1HwXu0lz_aJxRmXsI3uT1yXRGkqKjFQnLhUcGvT9sVQOAKZ9pBzF4f1h1eO-2St3yF06cHgwHzf8j	12	< 3 hours
5	7	Piotr Zieliński	Stolarz	+48 605 678 901	Custom woodwork and furniture restoration...	I craft bespoke furniture...	https://lh3.googleusercontent.com/aida-public/AB6AXuDrNcP9TfqmzqAQYkwkl9lLZmj_qfEgimHrG4n4VUVL9upNoT3r3nbS94Fh-VgHpNQpEyywI4l0_jnbWPvhq3hdiNUg7y4z5OS5FnaMODfmRyOUt0ra_XIQxKOe1iwrF9fGqV49kPI07pMMtB5ogrSGY6m87jBOIfSny0FjMYr8Bqk9qodkuX6fk3XTB7s3wvjWCxAtUcBuO7uHJhwIIToicQFmUySAYeQjULgBz4BVP0fbLWM1FVrIRHfpI2tFixnzKdBS8HLNvkE	20	< 1 day
6	8	Magdalena Wilk	Glazurnik	+48 606 789 012	Expert tiler transforming bathrooms...	I ensure every tile is perfectly aligned...	https://lh3.googleusercontent.com/aida-public/AB6AXuC3OW3zkIdttpqRag0xUupUP7IqmL51J32lfUqp3fUNz3JQQGHthIogVTsDTzrrV6AhQbg48gHCPKn_V71l7OEPdUmT6MFEBPvMIzCyj8NsKQSGfCtiZppNWX5HL8xf0JqfptSLPyXmyAB1R17MLbJtIMSBRhbp3bF1V2KMcNiW_bKKrDAfVjYYbLOjUDv8ywZLMoiuBPFa8mIZUXfHukX7G-NItLJbuJg0pEd3MK6q46bwyult2dYvB4X5NaWPZ-MwxWDUy0fUrBM	7	< 1 hour
7	9	Tomasz Król	Złota rączka	+48 607 890 123	All-around handyman for minor repairs...	No job too small...	https://lh3.googleusercontent.com/aida-public/AB6AXuAHW2ZglljagmqE8xNcYWBZRM9rUvRqaQol0oXLXBE9_m6KgcZNR-bBqe43VtowEeMbf8t-mVhg9leDBXj2rZbbqaYWXXRBcUVulMV-zJGEQLr3ZpJ0lJP4miVqhdlyXNmmTWq26qLyiarnpkBOoszsjBOlyMG_xRedEsCDTbSkoID5JUCDwv087Aiqr55otHbTcvCdx04FqWqR88moCTICSba_95JqlqeE2uQDzCgL_WtpqCkUM4WR895m7WU_-Ml6x54pWZwG85g	5	< 2 hours
8	11	Mario	Specialist	111222333	Update your profile description so clients know what you do best.	Tell clients about your experience, services and working style.	https://static.wikia.nocookie.net/wreckitralph/images/2/25/Mario_New_Super_Mario_Bros_U_Deluxe.png/revision/latest?cb=20190721210033	2	< 3 hour
\.


--
-- TOC entry 3490 (class 0 OID 16386)
-- Dependencies: 215
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users (id, email, password, role) FROM stdin;
1	jan.kowalski@example.com	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	User
2	anna.nowak@example.com	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	User
3	krzysztof.borys@example.com	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	User
4	adam.kowalski@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
5	marek.wisniewski@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
6	ewa.kaminska@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
7	piotr.zielinski@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
8	magdalena.wilk@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
9	tomasz.krol@pro.pl	$2y$10$dN0pQR5pF1f4kWd5Vxj6pOZLPc5pEW4bG8LZV2K7l0Z1wFbxv2.Zy	Specialist
10	AnnaKowalska@gmail.com	$2y$10$CHyzAsB5qMffmw3RLSrZGOBJ/Yt7DgS/fttjy21w2W/mZwc2Ajj5q	User
11	Mario@wp.pl	$2y$10$OXtHfAnCxPOJ1UhJ55/cROwRPZ2vDR09a6/xSKa0msGQ.qsMlBy9O	Specialist
\.


--
-- TOC entry 3517 (class 0 OID 0)
-- Dependencies: 225
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.categories_id_seq', 301, true);


--
-- TOC entry 3518 (class 0 OID 0)
-- Dependencies: 222
-- Name: locations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.locations_id_seq', 7, true);


--
-- TOC entry 3519 (class 0 OID 0)
-- Dependencies: 228
-- Name: portfolio_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.portfolio_items_id_seq', 8, true);


--
-- TOC entry 3520 (class 0 OID 0)
-- Dependencies: 216
-- Name: profiles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.profiles_id_seq', 11, true);


--
-- TOC entry 3521 (class 0 OID 0)
-- Dependencies: 220
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.reviews_id_seq', 11, true);


--
-- TOC entry 3522 (class 0 OID 0)
-- Dependencies: 218
-- Name: specialists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.specialists_id_seq', 8, true);


--
-- TOC entry 3523 (class 0 OID 0)
-- Dependencies: 214
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.users_id_seq', 11, true);


--
-- TOC entry 3331 (class 2606 OID 16482)
-- Name: categories categories_name_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_key UNIQUE (name);


--
-- TOC entry 3333 (class 2606 OID 16480)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 3327 (class 2606 OID 16458)
-- Name: locations locations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (id);


--
-- TOC entry 3337 (class 2606 OID 16506)
-- Name: portfolio_items portfolio_items_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.portfolio_items
    ADD CONSTRAINT portfolio_items_pkey PRIMARY KEY (id);


--
-- TOC entry 3317 (class 2606 OID 16403)
-- Name: profiles profiles_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_pkey PRIMARY KEY (id);


--
-- TOC entry 3319 (class 2606 OID 16405)
-- Name: profiles profiles_user_id_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT profiles_user_id_key UNIQUE (user_id);


--
-- TOC entry 3325 (class 2606 OID 16441)
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 3335 (class 2606 OID 16487)
-- Name: specialist_categories specialist_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_categories
    ADD CONSTRAINT specialist_categories_pkey PRIMARY KEY (specialist_id, category_id);


--
-- TOC entry 3329 (class 2606 OID 16463)
-- Name: specialist_locations specialist_locations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_locations
    ADD CONSTRAINT specialist_locations_pkey PRIMARY KEY (specialist_id, location_id);


--
-- TOC entry 3321 (class 2606 OID 16424)
-- Name: specialists specialists_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialists
    ADD CONSTRAINT specialists_pkey PRIMARY KEY (id);


--
-- TOC entry 3323 (class 2606 OID 16426)
-- Name: specialists specialists_user_id_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialists
    ADD CONSTRAINT specialists_user_id_key UNIQUE (user_id);


--
-- TOC entry 3313 (class 2606 OID 16396)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3315 (class 2606 OID 16394)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3342 (class 2606 OID 16469)
-- Name: specialist_locations fk_location; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_locations
    ADD CONSTRAINT fk_location FOREIGN KEY (location_id) REFERENCES public.locations(id) ON DELETE CASCADE;


--
-- TOC entry 3346 (class 2606 OID 16507)
-- Name: portfolio_items fk_portfolio_specialist; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.portfolio_items
    ADD CONSTRAINT fk_portfolio_specialist FOREIGN KEY (specialist_id) REFERENCES public.specialists(id) ON DELETE CASCADE;


--
-- TOC entry 3338 (class 2606 OID 16406)
-- Name: profiles fk_profile_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.profiles
    ADD CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 3340 (class 2606 OID 16442)
-- Name: reviews fk_review_specialist; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT fk_review_specialist FOREIGN KEY (specialist_id) REFERENCES public.specialists(id) ON DELETE CASCADE;


--
-- TOC entry 3341 (class 2606 OID 16447)
-- Name: reviews fk_review_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT fk_review_user FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- TOC entry 3343 (class 2606 OID 16464)
-- Name: specialist_locations fk_specialist; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_locations
    ADD CONSTRAINT fk_specialist FOREIGN KEY (specialist_id) REFERENCES public.specialists(id) ON DELETE CASCADE;


--
-- TOC entry 3344 (class 2606 OID 16493)
-- Name: specialist_categories fk_specialist_category_category; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_categories
    ADD CONSTRAINT fk_specialist_category_category FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 3345 (class 2606 OID 16488)
-- Name: specialist_categories fk_specialist_category_specialist; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialist_categories
    ADD CONSTRAINT fk_specialist_category_specialist FOREIGN KEY (specialist_id) REFERENCES public.specialists(id) ON DELETE CASCADE;


--
-- TOC entry 3339 (class 2606 OID 16427)
-- Name: specialists fk_specialist_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.specialists
    ADD CONSTRAINT fk_specialist_user FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


-- Completed on 2026-05-27 16:37:11 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict gWqeyuhaA4RvAjkcvHGffzohZfh1SVdfIqZ03Zpj9bUzA9g0OQeengFMM06vwKg

