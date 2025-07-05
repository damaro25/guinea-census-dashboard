--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)

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

--
-- Data for Name: map_indicators; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.map_indicators (id, name, slug, title, description, data_source, published, rank, created_at, updated_at) VALUES (2, 'MenageOrdinaire/MenageOrdinaire', 'menage-ordinaire.menage-ordinaire', '{"en": "Menage Ordinaire", "fr": "Menage collecter"}', '{"en": "Menage Ordinaire", "fr": "Menage Ordinaire"}', 'listing_ext', true, 1, '2025-03-07 10:58:23', '2025-07-04 14:04:11') ON CONFLICT DO NOTHING;
INSERT INTO public.map_indicators (id, name, slug, title, description, data_source, published, rank, created_at, updated_at) VALUES (1, 'Concession/NumbreofConcessions', 'concession.numbreof-concessions', '{"en": "Numbre de concessions", "fr": "Ménage concrétiser"}', '{"en": "numbre de concessions", "fr": "Menages"}', 'listing', true, 2, '2025-03-06 15:37:26', '2025-07-04 14:04:17') ON CONFLICT DO NOTHING;


--
-- Name: map_indicators_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.map_indicators_id_seq', 2, true);


--
-- PostgreSQL database dump complete
--

