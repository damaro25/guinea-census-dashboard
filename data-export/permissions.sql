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
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (1, 'enumerationpriv', 'web', '2025-01-31 08:57:42', '2025-01-31 08:57:42') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (2, 'enumerationinst', 'web', '2025-01-31 08:57:57', '2025-01-31 08:57:57') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (3, 'scorecards', 'web', '2025-02-04 17:31:51', '2025-02-04 17:31:51') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (4, 'menage-ordinaire:total-number-of-household:scorecard', 'web', '2025-02-04 17:31:51', '2025-02-04 17:31:51') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (5, 'menage-ordinaire:total-population:scorecard', 'web', '2025-02-04 17:32:42', '2025-02-04 17:32:42') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (6, 'menage-ordinaire:average-interview-time:scorecard', 'web', '2025-02-04 17:33:19', '2025-02-04 17:33:19') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (7, 'menage-ordinaire:average-household-size:scorecard', 'web', '2025-02-04 17:34:17', '2025-02-04 17:34:17') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (8, 'menage-ordinaire:households-enumerated-against-target-by-area:indicator', 'web', '2025-02-04 18:37:21', '2025-02-04 18:37:21') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (9, 'menage-ordinaire:population-enumerated-against-target-by-area:indicator', 'web', '2025-02-04 18:37:51', '2025-02-04 18:37:51') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (10, 'menage-ordinaire:percentage-of-household-enumerated-against-target-by-area:indicator', 'web', '2025-02-04 18:38:30', '2025-02-04 18:38:30') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (11, 'menage-ordinaire:percentage-of-population-enumerated-against-target-by-area:indicator', 'web', '2025-02-04 18:39:06', '2025-02-04 18:39:06') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (12, 'menage-ordinaire:households-enumerated-against-target-by-day:indicator', 'web', '2025-02-04 18:39:39', '2025-02-04 18:39:39') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (13, 'menage-ordinaire:population-enumerated-against-target-by-day:indicator', 'web', '2025-02-04 18:40:13', '2025-02-04 18:40:13') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (14, 'menage-ordinaire:household-enumerated-by-day-cumulative:indicator', 'web', '2025-02-04 18:40:50', '2025-02-04 18:40:50') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (15, 'menage-ordinaire:population-enumerated-by-day-cumulative:indicator', 'web', '2025-02-04 18:41:22', '2025-02-04 18:41:22') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (16, 'menage-ordinaire:population-pyramid:indicator', 'web', '2025-02-04 18:41:39', '2025-02-04 18:41:39') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (17, 'menage-ordinaire:average-household-size-by-area:indicator', 'web', '2025-02-04 18:42:15', '2025-02-04 18:42:15') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (18, 'menage-ordinaire:average-interview-time-by-area:indicator', 'web', '2025-02-04 18:42:36', '2025-02-04 18:42:36') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (19, 'menage-ordinaire:single-age-population:indicator', 'web', '2025-02-04 18:42:56', '2025-02-04 18:42:56') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (20, 'menage-ordinaire:sex-ratio:indicator', 'web', '2025-02-04 18:43:14', '2025-02-04 18:43:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (21, 'menage-ordinaire:crude-birth-rate-by-area:indicator', 'web', '2025-02-04 18:43:36', '2025-02-04 18:43:36') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (22, 'menage-ordinaire:crude-death-rate-by-area:indicator', 'web', '2025-02-04 18:43:59', '2025-02-04 18:43:59') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (23, 'menage-ordinaire:partially-completed-cases:indicator', 'web', '2025-02-04 18:44:24', '2025-02-04 18:44:24') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (25, 'concession:household-listed-against-target-by-area:indicator', 'web', '2025-02-25 08:22:24', '2025-02-25 08:22:24') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (26, 'concession:households-enumerated-against-target-by-day:indicator', 'web', '2025-02-25 08:25:32', '2025-02-25 08:25:32') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (27, 'concession:percentage-of-household-enumerated-against-target-by-area:indicator', 'web', '2025-02-25 08:26:32', '2025-02-25 08:26:32') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (28, 'concession:percentage-of-population-listed-against-target-by-area:indicator', 'web', '2025-02-25 08:27:39', '2025-02-25 08:27:39') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (29, 'concession:population-enumerated-against-target-by-area:indicator', 'web', '2025-02-25 08:32:15', '2025-02-25 08:32:15') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (30, 'concession:population-listed-against-target-by-day:indicator', 'web', '2025-02-25 08:34:37', '2025-02-25 08:34:37') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (31, 'concession:total-number-of-household:scorecard', 'web', '2025-03-02 17:37:10', '2025-03-02 17:37:10') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (32, 'concession:total-population:scorecard', 'web', '2025-03-02 17:37:35', '2025-03-02 17:37:35') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (33, 'concession:average-household-size:scorecard', 'web', '2025-03-02 17:37:58', '2025-03-02 17:37:58') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (34, 'menage-collectif:total-number-of-household:scorecard', 'web', '2025-03-02 17:46:12', '2025-03-02 17:46:12') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (35, 'menage-collectif:total-population:scorecard', 'web', '2025-03-02 17:46:23', '2025-03-02 17:46:23') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (36, 'specifique:site:scorecard', 'web', '2025-03-02 17:49:01', '2025-03-02 17:49:01') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (37, 'specifique:total-population:scorecard', 'web', '2025-03-02 17:49:25', '2025-03-02 17:49:25') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (38, 'menage-collectif:household-enumerated-by-area:indicator', 'web', '2025-03-02 18:01:58', '2025-03-02 18:01:58') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (39, 'menage-collectif:population-enumerated-by-area:indicator', 'web', '2025-03-02 18:02:38', '2025-03-02 18:02:38') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (40, 'specifique:population-enumerated-by-area:indicator', 'web', '2025-03-02 18:03:32', '2025-03-02 18:03:32') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (41, 'reports', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (42, 'maps', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (43, 'listing', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (44, 'concession:population-listed-against-target-by-area:indicator', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (45, 'concession:percentage-of-household-listed-against-target-by-area:indicator', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (46, 'concession:households-listed-against-target-by-day:indicator', 'web', '2025-03-05 11:44:29', '2025-03-05 11:44:29') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (47, 'menage-ordinaire:last-sync-not-recent:report', 'web', '2025-03-06 05:52:44', '2025-03-06 05:52:44') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (48, 'concession:last-synced-not-recent:report', 'web', '2025-03-06 05:53:16', '2025-03-06 05:53:16') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (49, 'concession:partial-by-e-a:report', 'web', '2025-03-06 05:56:48', '2025-03-06 05:56:48') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (50, 'map_indicators', 'web', '2025-03-06 15:37:26', '2025-03-06 15:37:26') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (51, 'concession:numbreof-concessions:map-indicator', 'web', '2025-03-06 15:37:26', '2025-03-06 15:37:26') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (52, 'menage-ordinaire:menage-ordinaire:map-indicator', 'web', '2025-03-07 10:58:23', '2025-03-07 10:58:23') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (54, 'menage-ordinaire:eas-not-started-enumeration:report', 'web', '2025-03-09 09:04:13', '2025-03-09 09:04:13') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (55, 'menage-ordinaire:enumerator-performance-with-date:report', 'web', '2025-03-09 09:06:39', '2025-03-09 09:06:39') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (56, 'concession:total-population-institution:scorecard', 'web', '2025-05-24 14:36:53', '2025-05-24 14:36:53') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (57, 'concession:total-number-of-household-institution:scorecard', 'web', '2025-05-24 14:36:53', '2025-05-24 14:36:53') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (58, 'menage-ordinaire:sex-ratio:scorecard', 'web', '2025-05-27 14:15:43', '2025-05-27 14:15:43') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (59, 'menage-ordinaire:coverage-table-by-region:indicator', 'web', '2025-05-27 15:58:47', '2025-05-27 15:58:47') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (60, 'menage-ordinaire:coverage-table-by-perfecture:indicator', 'web', '2025-05-27 15:59:35', '2025-05-27 15:59:35') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (61, 'enumeration:coverage-h-h-table-by-region:indicator', 'web', '2025-05-28 09:39:13', '2025-05-28 09:39:13') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (62, 'enumeration:coverage-h-h-table-by-perfecture:indicator', 'web', '2025-05-28 10:20:19', '2025-05-28 10:20:19') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (64, 'concession:household-listed-against-final-target-by-area:indicator', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (65, 'concession:population-listed-against-final-target-by-area:indicator', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (66, 'menage-ordinaire:eas-without-disability-register:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (67, 'menage-ordinaire:partial-cases-by-ea:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (68, 'menage-ordinaire:wrongly-dated-cases:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (69, 'menage-ordinaire:duplicate-cases-by-ea:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (70, 'menage-ordinaire:eas-with-low-performance:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (71, 'menage-ordinaire:average-hh-size-by-ea:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (72, 'concession:ea-not-started-listing:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (73, 'menage-ordinaire:eas-without-birth-register:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (74, 'concession:eas-with-low-performace:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (75, 'menage-ordinaire:average-interview-time-by-ea:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (76, 'concession:duplicated-cases:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (77, 'menage-ordinaire:eas-without-death-register:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (78, 'concession:hh-with-high-household-size:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (79, 'menage-ordinaire:eas-achieved-enumeration-target:report', 'web', '2025-05-29 15:31:14', '2025-05-29 15:31:14') ON CONFLICT DO NOTHING;
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (80, 'menage-ordinaire:difference-in-residentvs-visitor:indicator', 'web', '2025-05-30 14:12:26', '2025-05-30 14:12:26') ON CONFLICT DO NOTHING;


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 80, true);


--
-- PostgreSQL database dump complete
--

