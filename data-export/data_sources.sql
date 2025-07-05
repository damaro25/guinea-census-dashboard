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
-- Data for Name: data_sources; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.data_sources (id, name, title, start_date, end_date, case_stats_component, show_on_home_page, rank, host, port, database, username, password, connection_active, driver, created_at, updated_at) VALUES (5, 'listing_ext', '{"en": "Enumeration", "fr": "Collecte des données"}', '2025-03-17 00:00:00', '2025-04-17 00:00:00', 'overall-case-stats', true, 1, '127.0.0.1', '3306', 'brk_gn_concession', 'chimera', 'eyJpdiI6Ino5NmMwcnl4WnhXWUJ2SjNpd0NmVUE9PSIsInZhbHVlIjoiM3lXQThzMHJqNkJVV3ByNEJObFZidz09IiwibWFjIjoiNWIzMTI4NzdlMTM3ZGIzNWRhYmZmYTNkMjM5ZDAzZGNkMGZhNzk5MjkxN2RmODg1N2Y3NzRiZWI3NzkxMjIyZSIsInRhZyI6IiJ9', true, 'mysql', '2025-05-24 17:15:49', '2025-05-29 10:48:11') ON CONFLICT DO NOTHING;
INSERT INTO public.data_sources (id, name, title, start_date, end_date, case_stats_component, show_on_home_page, rank, host, port, database, username, password, connection_active, driver, created_at, updated_at) VALUES (1, 'menage_ordinaire', '{"en": "MenageOrdinaire", "fr": "Ménage ordinaire"}', '2025-03-17 00:00:00', '2025-04-10 00:00:00', 'menage-ordinaire-case-stats', true, 2, '127.0.0.1', '3306', 'brk_gn_menage_ordinaire', 'chimera', 'eyJpdiI6IkplMWcyQXNESUd2SmVxVTc0bEJvUGc9PSIsInZhbHVlIjoiWlFFUHFQNWhPcGhSVDZGOGhBbE55QT09IiwibWFjIjoiYzBhNDQ1YTJjMGNmOTExNTc2MmM1NjQ3ODc1ZDdjMDM0NzExN2QwOGNhYWVlZWJlMGUzYjMwZDY2NDAwZGVmMCIsInRhZyI6IiJ9', true, 'mysql', '2025-02-04 17:22:44', '2025-05-29 10:48:30') ON CONFLICT DO NOTHING;
INSERT INTO public.data_sources (id, name, title, start_date, end_date, case_stats_component, show_on_home_page, rank, host, port, database, username, password, connection_active, driver, created_at, updated_at) VALUES (3, 'menage_collectif', '{"en": "MenageCollectif", "fr": "Ménage collectif"}', '2025-03-02 00:00:00', '2025-03-08 00:00:00', 'menage-collectif-case-stats', true, 3, '127.0.0.1', '3306', 'brk_gn_collectif', 'chimera', 'eyJpdiI6InIwOC9qZHZ0U05hTzd2R0wrZk1MYkE9PSIsInZhbHVlIjoiRzJ5Y1VUTE8zWWRSNFgxdVhCemUxdz09IiwibWFjIjoiNjVkOTU5MzllNWExZDFiZjc5YWU1NTk5MzYwNDQ5MjlhZDlmMzc1MjlkZDA5NTIyNWJiYTlmMTEyMDg5MDRlNiIsInRhZyI6IiJ9', true, 'mysql', '2025-03-02 17:09:37', '2025-05-29 12:01:09') ON CONFLICT DO NOTHING;
INSERT INTO public.data_sources (id, name, title, start_date, end_date, case_stats_component, show_on_home_page, rank, host, port, database, username, password, connection_active, driver, created_at, updated_at) VALUES (4, 'specifique', '{"en": "Specifique", "fr": "Population specifique"}', '2025-03-02 00:00:00', '2025-03-08 00:00:00', 'menage-collectif-case-stats', true, 4, '127.0.0.1', '3306', 'brk_gn_population_specifique', 'chimera', 'eyJpdiI6InF3aFRic1MvcHEvVEtCaUtkd3E4Rmc9PSIsInZhbHVlIjoianNqMWoyaytPQ0lHbjFxZFljRytCZz09IiwibWFjIjoiMzk2MWVkMWIwNjE5MjdlZDM4OTgyODQzMDNlZTkyOGJmOTIwYjMwMzAzY2Q2NjFlOTNkM2NlNDNiNTJiNDFiZiIsInRhZyI6IiJ9', true, 'mysql', '2025-03-02 17:10:27', '2025-05-29 12:01:21') ON CONFLICT DO NOTHING;
INSERT INTO public.data_sources (id, name, title, start_date, end_date, case_stats_component, show_on_home_page, rank, host, port, database, username, password, connection_active, driver, created_at, updated_at) VALUES (2, 'listing', '{"en": "Concession", "fr": "Concrétisation"}', '2025-05-23 00:00:00', '2025-05-26 00:00:00', 'listing-case-stats', true, 0, '127.0.0.1', '3306', 'brk_gn_concession', 'chimera', 'eyJpdiI6InVpTlQwSUdMeHo0bmhmY0RhcDJpMWc9PSIsInZhbHVlIjoiN0FmUnhlZnlHS1RxRnM0VHFtc1RzUT09IiwibWFjIjoiNTY2NmE4YzRmNzIxNTA0ZjljZWRkMDEzYjNiMzI5ODVlZmJjMjE4OTc3Yjk0ODhkODBkY2VkOTA2NTQ3OWUzOCIsInRhZyI6IiJ9', true, 'mysql', '2025-02-25 07:49:19', '2025-05-29 10:47:49') ON CONFLICT DO NOTHING;


--
-- Name: data_sources_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_sources_id_seq', 5, true);


--
-- PostgreSQL database dump complete
--

