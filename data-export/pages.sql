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
-- Data for Name: pages; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.pages (id, title, slug, description, published, rank, created_at, updated_at) VALUES (2, '{"en": "Enumeration(inst)", "fr": "Ménage collectif/Specifique"}', 'enumerationinst', '{"fr": null}', true, 3, '2025-01-31 08:57:57', '2025-03-02 18:09:04') ON CONFLICT DO NOTHING;
INSERT INTO public.pages (id, title, slug, description, published, rank, created_at, updated_at) VALUES (1, '{"en": "Enumeration(priv)", "fr": "Ménage ordinaire"}', 'enumerationpriv', '{"fr": null}', true, 2, '2025-01-31 08:57:42', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.pages (id, title, slug, description, published, rank, created_at, updated_at) VALUES (3, '{"en": "Listing", "fr": "Concrétisation"}', 'listing', '{"fr": null}', true, 1, '2025-02-25 07:50:14', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;


--
-- Name: pages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pages_id_seq', 4, true);


--
-- PostgreSQL database dump complete
--

