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
-- Data for Name: scorecards; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (3, 'MenageOrdinaire/AverageInterviewTime', 'menage-ordinaire.average-interview-time', '{"en": "Average InterviewTime", "fr": "Durée moyenne de l''interview (minutes)"}', 'menage_ordinaire', true, NULL, 4, '2025-02-04 17:33:19', '2025-02-06 16:37:37') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (11, 'Specifique/TotalPopulation', 'specifique.total-population', '{"en": "TotalPopulationSpecifique", "fr": "Population totale(Specifique)"}', 'specifique', true, NULL, 1, '2025-03-02 17:49:25', '2025-03-02 18:00:00') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (10, 'Specifique/Site', 'specifique.site', '{"en": "Site", "fr": "Site"}', 'specifique', true, NULL, 0, '2025-03-02 17:49:01', '2025-03-02 18:00:34') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (14, 'MenageOrdinaire/SexRatio', 'menage-ordinaire.sex-ratio', '{"en": "Sex Ratio", "fr": "hommes pour 100 femmes"}', 'menage_ordinaire', true, NULL, 7, '2025-05-27 14:15:43', '2025-05-27 14:34:19') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (4, 'MenageOrdinaire/AverageHouseholdSize', 'menage-ordinaire.average-household-size', '{"en": "Average Household Size", "fr": "Taille moyenne des ménages ordinaires"}', 'menage_ordinaire', true, NULL, 3, '2025-02-04 17:34:17', '2025-05-30 13:55:35') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (12, 'Concession/TotalNumberOfHouseholdInstitution', 'concession.total-number-of-household-institution', '{"en": "Total Number of Household - institution", "fr": "Total des ménages collectifs identifés"}', 'listing', true, NULL, 4, '2025-03-02 17:37:10', '2025-05-30 13:57:22') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (9, 'MenageCollectif/TotalPopulation', 'menage-collectif.total-population', '{"en": "Population", "fr": "Population totale"}', 'menage_collectif', true, NULL, 1, '2025-03-02 17:46:23', '2025-05-30 13:58:36') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (13, 'Concession/TotalPopulationInstitution', 'concession.total-population-institution', '{"en": "Total Population - institution", "fr": "Population totale identifée - Menage Collectif"}', 'listing', false, NULL, 5, '2025-03-02 17:37:35', '2025-06-30 18:47:25') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (6, 'Concession/TotalPopulation', 'concession.total-population', '{"en": "Total Population - private household", "fr": "Population totale des ménages ordinaires et collectifs identifiés."}', 'listing', true, NULL, 2, '2025-03-02 17:37:35', '2025-06-30 18:50:42') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (5, 'Concession/TotalNumberOfHousehold', 'concession.total-number-of-household', '{"en": "Total Number of Household Private", "fr": "Totale des ménages ordinaires identifés"}', 'listing', true, NULL, 1, '2025-03-02 17:37:10', '2025-05-24 07:28:55') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (8, 'MenageCollectif/TotalNumberOfHousehold', 'menage-collectif.total-number-of-household', '{"en": "Institution", "fr": "Total des ménages collectifs"}', 'menage_collectif', true, NULL, 0, '2025-03-02 17:46:12', '2025-06-30 19:03:23') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (1, 'MenageOrdinaire/TotalNumberOfHousehold', 'menage-ordinaire.total-number-of-household', '{"en": "Total Number of Household", "fr": "Total menages ordiniaires  collectés"}', 'menage_ordinaire', true, NULL, 1, '2025-02-04 17:31:51', '2025-05-24 12:30:36') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (7, 'Concession/AverageHouseholdSize', 'concession.average-household-size', '{"en": "Average Household Size", "fr": "Taille moyenne des ménages ordinaires carto - concretisée"}', 'listing', true, NULL, 3, '2025-03-02 17:37:58', '2025-06-30 19:04:59') ON CONFLICT DO NOTHING;
INSERT INTO public.scorecards (id, name, slug, title, data_source, published, linked_indicator, rank, created_at, updated_at) VALUES (2, 'MenageOrdinaire/TotalPopulation', 'menage-ordinaire.total-population', '{"en": "Total Population", "fr": "Population totale de menages ordinaires collectés"}', 'menage_ordinaire', true, NULL, 2, '2025-02-04 17:32:42', '2025-05-24 12:34:07') ON CONFLICT DO NOTHING;


--
-- Name: scorecards_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.scorecards_id_seq', 14, true);


--
-- PostgreSQL database dump complete
--

