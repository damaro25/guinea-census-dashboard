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
-- Data for Name: indicator_page; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (24, 23, 2, 0, '2025-03-02 18:07:23', '2025-03-02 18:09:04') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (23, 24, 2, 1, '2025-03-02 18:07:08', '2025-03-02 18:09:04') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (25, 25, 2, 2, '2025-03-02 18:07:56', '2025-03-02 18:09:04') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (26, 27, 3, 3, '2025-05-25 08:53:12', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (20, 19, 3, 4, '2025-02-25 10:20:57', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (22, 20, 3, 5, '2025-02-25 10:23:35', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (19, 18, 3, 6, '2025-02-25 10:20:45', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (18, 22, 3, 7, '2025-02-25 10:20:37', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (29, 28, 3, 8, '2025-05-28 09:31:43', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (28, 29, 3, 9, '2025-05-27 18:37:08', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (33, 33, 1, 0, '2025-05-30 14:46:50', '2025-05-30 14:46:50') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (1, 1, 1, 0, '2025-02-04 18:53:00', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (2, 2, 1, 1, '2025-02-04 18:55:18', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (3, 3, 1, 2, '2025-02-05 04:07:13', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (4, 4, 1, 3, '2025-02-05 04:08:03', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (6, 5, 1, 4, '2025-02-05 06:34:04', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (7, 6, 1, 5, '2025-02-05 06:35:03', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (5, 7, 1, 6, '2025-02-05 06:33:46', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (8, 8, 1, 7, '2025-02-05 06:35:49', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (30, 30, 1, 8, '2025-05-28 09:51:10', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (31, 31, 1, 9, '2025-05-28 10:21:52', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (10, 10, 1, 10, '2025-02-06 05:59:01', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (9, 9, 1, 11, '2025-02-05 18:09:31', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (15, 13, 1, 12, '2025-02-06 07:59:55', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (12, 12, 1, 13, '2025-02-06 06:23:45', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (14, 15, 1, 14, '2025-02-06 07:52:24', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (13, 14, 1, 15, '2025-02-06 07:52:12', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (11, 11, 1, 16, '2025-02-06 06:09:12', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (16, 16, 1, 17, '2025-02-06 08:04:16', '2025-05-28 12:32:28') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (32, 32, 3, 0, '2025-05-29 14:22:04', '2025-05-29 14:22:04') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (17, 17, 3, 0, '2025-02-25 10:14:20', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (21, 21, 3, 1, '2025-02-25 10:21:05', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;
INSERT INTO public.indicator_page (id, indicator_id, page_id, rank, created_at, updated_at) VALUES (27, 26, 3, 2, '2025-05-25 08:55:56', '2025-05-30 12:31:26') ON CONFLICT DO NOTHING;


--
-- Name: indicator_page_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.indicator_page_id_seq', 33, true);


--
-- PostgreSQL database dump complete
--

