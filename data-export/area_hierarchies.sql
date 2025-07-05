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
-- Data for Name: area_hierarchies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (2, 1, '{"en": "PRÉFECTURE", "fr": "PRÉFECTURE"}', 2, 0, '[6]', '2025-01-31 08:48:25', '2025-02-18 08:40:23') ON CONFLICT DO NOTHING;
INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (6, 3, '{"en": "Zone de Supervision", "fr": "ZS"}', 5, 0, '[6]', '2025-02-18 08:02:42', '2025-03-06 03:45:23') ON CONFLICT DO NOTHING;
INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (1, 0, '{"en": "REGION", "fr": "REGION"}', 0, 0, '[6]', '2025-01-31 08:48:08', '2025-03-06 14:50:37') ON CONFLICT DO NOTHING;
INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (3, 2, '{"en": "SOUS-PRÉFECTURE/COMMUNE", "fr": "SOUS-PRÉFECTURE/COMMUNE"}', 4, 0, '[6]', '2025-01-31 08:50:06', '2025-03-06 15:27:27') ON CONFLICT DO NOTHING;
INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (8, 4, '{"en": "ZC", "fr": "ZC"}', 0, 0, NULL, '2025-03-06 03:44:50', '2025-03-06 03:44:50') ON CONFLICT DO NOTHING;
INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, map_zoom_levels, created_at, updated_at) VALUES (9, 5, '{"en": "ZD", "fr": "ZD"}', 0, 0, NULL, '2025-03-06 03:45:13', '2025-03-06 03:45:13') ON CONFLICT DO NOTHING;


--
-- Name: area_hierarchies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.area_hierarchies_id_seq', 9, true);


--
-- PostgreSQL database dump complete
--

