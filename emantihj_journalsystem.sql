-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2025 at 04:11 PM
-- Server version: 11.4.8-MariaDB-cll-lve
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emantihj_journalsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_analytics`
--

CREATE TABLE `article_analytics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(191) NOT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `user_agent` varchar(191) DEFAULT NULL,
  `referrer` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE `custom_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `content` text DEFAULT NULL,
  `widgets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`widgets`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `template` varchar(191) NOT NULL DEFAULT 'default',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT 0,
  `menu_label` varchar(191) DEFAULT NULL,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_comments`
--

CREATE TABLE `discussion_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thread_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_threads`
--

CREATE TABLE `discussion_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_driver` varchar(255) NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) NOT NULL DEFAULT '587',
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_encryption` varchar(255) NOT NULL DEFAULT 'tls',
  `mail_from_address` varchar(255) DEFAULT NULL,
  `mail_from_name` varchar(255) NOT NULL DEFAULT 'EMANP',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_address`, `mail_from_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'emanp.org', '465', 'contact@emanp.org', 'Emanp@786*', 'ssl', 'contact@emanp.org', 'EMANP', 1, '2025-12-11 04:43:25', '2025-12-11 04:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `galleys`
--

CREATE TABLE `galleys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('pdf','html','xml') NOT NULL DEFAULT 'pdf',
  `label` varchar(191) DEFAULT NULL,
  `file_path` varchar(191) NOT NULL,
  `original_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_status` enum('pending','approved','changes_requested') NOT NULL DEFAULT 'pending',
  `author_comments` text DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `issue_number` int(11) DEFAULT NULL,
  `year` year(4) NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `journal_id`, `volume`, `issue_number`, `year`, `title`, `description`, `published_date`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026', NULL, 'Volume 1 Issue 1', '2025-12-12', 1, '2025-12-12 14:02:09', '2025-12-12 14:02:09'),
(2, 2, 1, 1, '2026', NULL, 'Volume 1 Issue 1', '2025-12-12', 1, '2025-12-12 14:02:38', '2025-12-12 14:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `journal_initials` varchar(191) DEFAULT NULL,
  `authors` text DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `journal_url` varchar(191) DEFAULT NULL,
  `journal_abbreviation` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `aims_scope` text DEFAULT NULL,
  `focus_scope` longtext DEFAULT NULL,
  `publication_frequency` text DEFAULT NULL,
  `peer_review_process` longtext DEFAULT NULL,
  `peer_review_policy` longtext DEFAULT NULL,
  `open_access_policy` longtext DEFAULT NULL,
  `copyright_notice` text DEFAULT NULL,
  `privacy_statement` longtext DEFAULT NULL,
  `editorial_board` text DEFAULT NULL,
  `editorial_team` longtext DEFAULT NULL,
  `editor_in_chief` text DEFAULT NULL,
  `managing_editor` text DEFAULT NULL,
  `section_editors` longtext DEFAULT NULL,
  `editorial_board_members` longtext DEFAULT NULL,
  `submission_guidelines` text DEFAULT NULL,
  `author_guidelines` longtext DEFAULT NULL,
  `submission_requirements` longtext DEFAULT NULL,
  `submission_checklist` longtext DEFAULT NULL,
  `competing_interest_statement` longtext DEFAULT NULL,
  `copyright_agreement` longtext DEFAULT NULL,
  `review_rounds` int(11) NOT NULL DEFAULT 2,
  `review_method` varchar(191) DEFAULT NULL,
  `requires_review` tinyint(1) NOT NULL DEFAULT 1,
  `review_forms` text DEFAULT NULL,
  `article_metadata_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`article_metadata_options`)),
  `email_templates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`email_templates`)),
  `contact_email` varchar(191) DEFAULT NULL,
  `contact_phone` varchar(191) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `primary_contact_name` varchar(191) DEFAULT NULL,
  `primary_contact_email` varchar(191) DEFAULT NULL,
  `support_contact_name` varchar(191) DEFAULT NULL,
  `support_email` varchar(191) DEFAULT NULL,
  `issn` varchar(191) DEFAULT NULL,
  `online_issn` varchar(191) DEFAULT NULL,
  `print_issn` varchar(191) DEFAULT NULL,
  `doi_prefix` varchar(191) DEFAULT NULL,
  `doi_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `logo` varchar(191) DEFAULT NULL,
  `cover_image` varchar(191) DEFAULT NULL,
  `favicon` varchar(191) DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `theme` varchar(191) NOT NULL DEFAULT 'default',
  `homepage_content` longtext DEFAULT NULL,
  `homepage_widgets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`homepage_widgets`)),
  `page_builder_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`page_builder_settings`)),
  `footer_content` text DEFAULT NULL,
  `navigation_menu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`navigation_menu`)),
  `color_scheme` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`color_scheme`)),
  `slider_blocks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`slider_blocks`)),
  `indexing_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`indexing_metadata`)),
  `archive_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archive_settings`)),
  `payment_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_settings`)),
  `license_type` varchar(191) DEFAULT NULL,
  `primary_language` varchar(191) NOT NULL DEFAULT 'en',
  `additional_languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_languages`)),
  `timezone` varchar(191) DEFAULT NULL,
  `date_format` varchar(191) DEFAULT NULL,
  `allowed_formats` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_formats`)),
  `max_file_size` int(11) NOT NULL DEFAULT 10,
  `plagiarism_check_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `name`, `journal_initials`, `authors`, `slug`, `journal_url`, `journal_abbreviation`, `description`, `aims_scope`, `focus_scope`, `publication_frequency`, `peer_review_process`, `peer_review_policy`, `open_access_policy`, `copyright_notice`, `privacy_statement`, `editorial_board`, `editorial_team`, `editor_in_chief`, `managing_editor`, `section_editors`, `editorial_board_members`, `submission_guidelines`, `author_guidelines`, `submission_requirements`, `submission_checklist`, `competing_interest_statement`, `copyright_agreement`, `review_rounds`, `review_method`, `requires_review`, `review_forms`, `article_metadata_options`, `email_templates`, `contact_email`, `contact_phone`, `contact_address`, `primary_contact_name`, `primary_contact_email`, `support_contact_name`, `support_email`, `issn`, `online_issn`, `print_issn`, `doi_prefix`, `doi_enabled`, `logo`, `cover_image`, `favicon`, `settings`, `theme`, `homepage_content`, `homepage_widgets`, `page_builder_settings`, `footer_content`, `navigation_menu`, `color_scheme`, `slider_blocks`, `indexing_metadata`, `archive_settings`, `payment_settings`, `license_type`, `primary_language`, `additional_languages`, `timezone`, `date_format`, `allowed_formats`, `max_file_size`, `plagiarism_check_required`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Excellence in Management & Academic Network Publishing (EMANP)', 'EMANP', 'Dr. Ahmed Raza, PhD Dr. Maria Johnson, PhD Prof. Syed Asad Ali Dr. Hira Khan', 'excellence-in-management-academic-network-publishing-emanp', NULL, 'Journal of Management – EMANP', '<p>Excellence in Management &amp; Academic Network Publishing (EMANP) is an international, peer-reviewed, open-access journal dedicated to advancing research in business, management, social sciences, entrepreneurship, digital innovation, and academic publishing.\r\nThe journal aims to provide a platform for scholars, researchers, academics, and practitioners to publish high-quality empirical and theoretical research that contributes to global knowledge.\r\n\r\nEMANP publishes original research articles, review papers, case studies, short communications, and conference special issues.</p>', 'EMANP welcomes contributions in the following areas:\r\n\r\nBusiness Management\r\nHuman Resource Management\r\nFinance & Accounting\r\nMarketing & Digital Media\r\nSupply Chain & Operations\r\nEntrepreneurship & Startups\r\nEducational Leadership & Policy\r\nInnovation & Technology Management\r\nSocial Sciences & Behavioral Studies\r\nAcademic Publishing & Research Trends', '<h1><strong>Testing</strong></h1><h3>Live Editor</h3>', NULL, NULL, '<p><br></p>', '<p><br></p>', NULL, '<p><br></p>', '<p>Editorial</p>', NULL, '<p><br></p>', '<p><br></p>', '<p><br></p>', '<p><br></p>', 'Quarterly (4 Issues per Year)\r\n(March, June, September, December)', '<p><br></p>', '<p><br></p>', '<p><br></p>', '<p><br></p>', '<p><br></p>', 2, NULL, 1, NULL, NULL, '{\"submission_received\":{\"subject\":\"Submission Received\",\"body\":\"Submission received\"},\"reviewer_invitation\":{\"subject\":\"Review Request\",\"body\":\"Review Request\"},\"acceptance_letter\":{\"subject\":\"Acceptance of Paper\",\"body\":\"Acceptance of Paper\"},\"publication_confirmation\":{\"subject\":\"Published\",\"body\":\"Published\"}}', 'testing222@gmail.com', '31548416441', 'Testing Shah', NULL, NULL, NULL, NULL, '2790-1234', NULL, NULL, '25856', 0, 'journals/logos/s3R6u2EVw0k5l8380grm6RkMT1mjbkVwu8v6QjQy.png', 'journals/covers/UCPUv7H5xWKk8aQRBVMmwbL7NNdse8eksc2S34C4.jpg', NULL, NULL, 'default', '<p><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', NULL, 'UTC', 'Y-m-d', '[\"pdf\"]', 10, 0, 1, '2025-12-04 17:33:09', '2025-12-12 13:59:49'),
(2, 'EMANP (Excellence in Management & Academic Network Publishing)', 'EMANP', 'Dr. Ahmed Raza, PhD Dr. Maria Johnson, PhD Prof. Syed Asad Ali Dr. Hira Khan', 'emanp-excellence-in-management-academic-network-publishing', NULL, 'Journal of Management – EMANP', '<p><strong>Excellence in Management &amp; Academic Network Publishing (EMANP)</strong> is an international, peer-reviewed academic journal focused on high-quality research in Management, Business Studies, Economics, Innovation, and Organizational Development. The journal aims to promote academic excellence by providing a platform for researchers, scholars, and professionals to publish original and impactful research.</p><p> EMANP welcomes empirical studies, theoretical papers, literature reviews, case studies, and applied research relevant to modern management practices and global business challenges.</p>', NULL, '<p><em>Excellence in Management &amp; Academic Network Publishing (EMANP)</em> publishes high-quality research in the following areas:</p><h3><strong>Core Focus Areas</strong></h3><ul><li>Management Sciences</li><li>Business Administration</li><li>Entrepreneurship &amp; Innovation</li><li>Leadership &amp; Human Resource Management</li><li>Digital Transformation &amp; Technology Management</li><li>Finance, Accounting &amp; Economics</li><li>Marketing, Consumer Behavior &amp; Branding</li><li>Organizational Development &amp; Strategy</li><li>Supply Chain &amp; Operations Management</li><li>Academic Research &amp; Interdisciplinary Studies</li></ul><p><strong>Scope:</strong></p><p> The journal welcomes empirical research, theoretical analyses, case studies, systematic reviews, conceptual papers, and applied research contributing to global business and academic knowledge.</p>', 'yearly', NULL, '<p>EMANP follows a <strong>double-blind peer review</strong> process:</p><ol><li>Each submitted manuscript is screened by the editorial office.</li><li>Suitable manuscripts are sent to <strong>two independent reviewers</strong> with expertise in the subject area.</li><li>Authors\' identities remain hidden from reviewers and vice versa.</li><li>Reviewers evaluate originality, methodology, relevance, clarity, and scholarly contribution.</li><li>Final acceptance is based on:</li></ol><ul><li class=\"ql-indent-1\">Reviewer recommendations</li><li class=\"ql-indent-1\">Editorial assessment</li><li class=\"ql-indent-1\">Compliance with journal ethics and standards</li></ul><p>The editorial team may request revisions before making the final decision.</p>', '<p>EMANP provides <strong>immediate and unrestricted open access</strong> to all published articles.</p><p> Readers may read, download, copy, distribute, print, or link to the full text, without requiring permission from the publisher or authors — provided proper citation is given.</p><p>Open access promotes global knowledge sharing and enhances the visibility of scholarly work.</p>', 'Authors retain copyright of their published work.\r\nBy submitting to EMANP, authors agree to grant the journal a non-exclusive license to publish and distribute the accepted manuscript.\r\nArticles are published under the Creative Commons Attribution 4.0 International License (CC BY 4.0), allowing:\r\nSharing\r\nAdaptation\r\nDistribution\r\nCommercial & Non-Commercial use\r\nwith proper attribution to the author(s).', '<p>The personal information collected by EMANP — including names, emails, and institutional details — is used <strong>solely</strong> for academic and publication purposes.</p><p>We do not share, sell, or disclose personal data to any third party, except when required for indexing or academic integrity verification.</p>', NULL, NULL, '<p><strong>Dr. Ahmed Raza, PhD</strong></p><p> Professor of Management Sciences</p><p> International Business School</p><p> Email: editor@emanp.org</p>', '<p><strong>Dr. Hira Khan</strong></p><p> Senior Lecturer in Business &amp; Economics</p><p> Email: managing.editor@emanp.org</p><p><br></p>', '<p><strong>Business &amp; Management:</strong> Prof. Syed Asad Ali</p><p><strong>Economics &amp; Finance:</strong> Dr. Maria Johnson</p><p><strong>Entrepreneurship &amp; Innovation:</strong> Dr. Umar Farooq</p><p><strong>Digital Transformation:</strong> Engr. Ali Zubair</p>', '<p>Dr. Sarah Lopez – University of Toronto</p><p>Dr. Chen Wei – Beijing Institute of Economics</p><p>Prof. Michael Harper – London School of Business</p><p>Dr. Rehana Iqbal – University of Karachi</p><p>Dr. Kamran Malik – Lahore School of Economics</p><p>Dr. Sofia Ahmed – Istanbul Business University</p><p>Dr. David Kim – Seoul Management Institute</p>', '<p>SET</p>', '<p>Authors must follow the guidelines below before submission:</p><h3><strong>Manuscript Structure</strong></h3><ul><li>Title</li><li>Abstract (150–250 words)</li><li>Keywords (3–6)</li><li>Introduction</li><li>Literature Review</li><li>Methodology</li><li>Results &amp; Discussion</li><li>Conclusion</li><li>References (APA 7th Edition)</li></ul><h3><strong>Formatting</strong></h3><ul><li>File type: Word Document (DOC/DOCX)</li><li>Font: Times New Roman, 12 pt</li><li>Spacing: 1.5</li><li>Margins: 1 inch on all sides</li></ul><h3><strong>Originality</strong></h3><p>Manuscripts must be <strong>original</strong>, unpublished, and not under review elsewhere.</p><p> Plagiarism must not exceed <strong>15%</strong> (excluding references).</p>', '<ul><li>Full manuscript in DOC/DOCX format</li><li>Author information page</li><li>Ethical approval (if human subjects or surveys involved)</li><li>Plagiarism report</li><li>Declaration of originality</li></ul><p><br></p>', '<p>Before submitting, ensure that:</p><p>✔ Manuscript follows the journal template</p><p> ✔ All co-authors\' details are included</p><p> ✔ Figures and tables are properly labeled</p><p> ✔ References follow APA 7 style</p><p> ✔ Plagiarism is under 15%</p><p> ✔ Ethical approval (if required) is attached</p><p> ✔ ORCID IDs (optional) are added</p>', '<p>Authors must disclose any financial, academic, or personal relationships that may influence the research.</p><p> If no conflict exists, authors must include the statement:</p><p><strong>“The authors declare no competing interests.”</strong></p>', '<p>Authors must confirm that:</p><ol><li>The manuscript is original and not published elsewhere.</li><li>All co-authors have agreed to the submission.</li><li>The article is licensed under <strong>CC BY 4.0</strong> once published.</li><li>The journal has the right to publish, archive, and disseminate the article.</li></ol><p><br></p>', 2, 'single_blind', 1, NULL, NULL, '{\"submission_received\":{\"subject\":\"Submission received\",\"body\":\"Submission received\"},\"acceptance_letter\":{\"subject\":\"Acceptance of Paper\",\"body\":\"Acceptance of Paper\"},\"publication_confirmation\":{\"subject\":\"Published\",\"body\":\"Published\"}}', NULL, '25155', 'Journal of Management – EMANP', 'Shah Developer', 'contact@journal.com', NULL, 'contact@journal.com', NULL, NULL, '250030', NULL, 0, 'journals/logos/ekLKGShucL9gQ0hYrMd4kqhwdgaIG8ApJmH9BNUi.png', 'journals/covers/oXwtRB9YH18b7sMZ0LiL4O8MkifV5nfiME9jzTRO.png', NULL, NULL, 'default', '<p><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', NULL, 'UTC', 'Y-m-d', '[\"pdf\"]', 10, 0, 1, '2025-12-04 21:26:17', '2025-12-12 14:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `journal_sections`
--

CREATE TABLE `journal_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `section_editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `word_limit_min` int(11) DEFAULT NULL,
  `word_limit_max` int(11) DEFAULT NULL,
  `review_type` varchar(191) NOT NULL DEFAULT 'double_blind',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_sections`
--

INSERT INTO `journal_sections` (`id`, `journal_id`, `title`, `slug`, `description`, `section_editor_id`, `word_limit_min`, `word_limit_max`, `review_type`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES
(1, 2, 'Testing Submission', 'testing-submission', 'Teseting Submission Description', NULL, 500, 700, 'open', 0, 1, NULL, '2025-12-08 00:15:42', '2025-12-08 00:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `journal_users`
--

CREATE TABLE `journal_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(191) NOT NULL,
  `section` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_users`
--

INSERT INTO `journal_users` (`id`, `journal_id`, `user_id`, `role`, `section`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'journal_manager', NULL, 1, '2025-12-10 05:52:11', '2025-12-10 05:52:11'),
(2, 1, 5, 'journal_manager', NULL, 1, '2025-12-11 22:07:51', '2025-12-11 22:07:51'),
(4, 2, 5, 'journal_manager', NULL, 1, '2025-12-11 22:09:12', '2025-12-11 22:09:12'),
(5, 1, 6, 'reviewer', NULL, 1, '2025-12-11 22:10:22', '2025-12-11 22:10:22'),
(6, 2, 6, 'reviewer', NULL, 1, '2025-12-11 22:10:38', '2025-12-11 22:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000001_create_users_table', 1),
(3, '2024_01_01_000002_create_journals_table', 1),
(4, '2024_01_01_000003_create_issues_table', 1),
(5, '2024_01_01_000003_create_journal_users_table', 1),
(6, '2024_01_01_000004_create_submissions_table', 1),
(7, '2024_01_01_000005_create_submission_files_table', 1),
(8, '2024_01_01_000006_create_submission_authors_table', 1),
(9, '2024_01_01_000007_create_reviews_table', 1),
(10, '2024_01_01_000008_create_review_files_table', 1),
(11, '2024_01_01_000009_create_submission_logs_table', 1),
(12, '2024_01_01_000010_create_payments_table', 1),
(13, '2024_01_01_000011_create_references_table', 1),
(14, '2024_01_01_000013_create_password_reset_tokens_table', 1),
(15, '2024_01_01_000014_create_sessions_table', 1),
(16, '2025_12_05_005837_add_new_fields_to_journals_table', 2),
(17, '2025_12_05_012208_add_authors_field_to_journals_table', 3),
(18, '2025_12_05_014121_add_comprehensive_fields_to_journals_table', 4),
(19, '2025_12_06_000001_create_custom_pages_table', 5),
(20, '2025_12_06_000002_create_widgets_table', 5),
(21, '2025_12_06_000003_add_page_builder_to_journals_table', 5),
(22, '2025_12_07_013129_create_article_analytics_table', 6),
(23, '2025_12_07_143322_create_journal_sections_table', 7),
(24, '2025_12_07_143352_add_reviewer_fields_to_reviews_table', 8),
(25, '2025_12_07_143434_add_versioning_to_submission_files_table', 9),
(26, '2025_12_07_160432_add_supporting_agencies_to_submissions_table', 10),
(27, '2025_12_07_161038_add_country_to_submission_authors_table', 11),
(28, '2025_12_07_180121_add_requires_review_to_journals_table', 12),
(29, '2025_12_07_205736_create_email_settings_table', 13),
(30, '2025_12_08_000001_add_notification_settings_to_users_table', 14),
(31, '2025_12_10_103900_create_discussion_threads_table', 15),
(32, '2025_12_10_103901_create_discussion_comments_table', 15),
(33, '2025_12_10_103959_add_copyedit_approval_to_submissions_table', 15),
(34, '2025_12_10_104008_create_galleys_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `references`
--

CREATE TABLE `references` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `reference_text` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `recommendation` text DEFAULT NULL,
  `reviewer_rating` int(11) DEFAULT NULL,
  `reviewer_expertise` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reviewer_expertise`)),
  `comments_for_editor` text DEFAULT NULL,
  `comments_for_author` text DEFAULT NULL,
  `comments_for_editors` text DEFAULT NULL,
  `comments_for_authors` text DEFAULT NULL,
  `assigned_date` date NOT NULL,
  `due_date` date NOT NULL,
  `submitted_date` date DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `review_time_days` int(11) DEFAULT NULL,
  `review_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`review_history`)),
  `decline_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_files`
--

CREATE TABLE `review_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `file_path` varchar(191) NOT NULL,
  `original_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1oA81iI9BZxR4gebO8hsjkzSwRL12hh6VR3SX0Q9', NULL, '43.157.158.178', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVA5aWRXdTNpa1VibHVZU3BsR1BNdUpKT1p4djUybEE0Wkt3VFd0QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZy9qb3VybmFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765540981),
('2egnoy8mPhOeYQXxXBHCmSTfgnvcjimr65B6CxLf', NULL, '149.57.180.196', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1VwS3FweVFLSnBWU0M0VnJMVHVGUklWd2h3OFlxN3U5elU2dGNteCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765568681),
('2SAMQ8a4hsPR1IJXGojTub7YEvTiJmUQtBzM5SNI', NULL, '172.236.122.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWtVTmk0VGhvdU44dktlN2s2Q3FwTzBuVlAyMWFGQXl2Q09Ka3VpSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765537610),
('43aMrHkHEVB6fHePP55xZkbcXdfqZqGmoj9Wu1La', NULL, '43.135.142.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejRwVmkzbzM2bjJpeXZPSXJZSnlaTW5JQm0yeXlyRUdXREt5bXRlaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765573433),
('6YkIHJfk6Gxtw8bHqgQmWLlp9Zn9uZl7vQYVp9T2', NULL, '135.148.195.12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/114.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieWZUM3VDSHNyMUgwWkJYbldHS2czYUdGckFvU0VhSVZ3YlJuTjlnZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765573730),
('73FDksKCkIshOZXKEFZzTBHAVnRH8ZefUTMWB2Fe', NULL, '45.145.119.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36/Nutch-1.21-SNAPSHOT', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzlaSkhEMzNXejRFMk5HZFUzNFlPempOc1hZcXhyZVBycmlkeG5leSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765542833),
('8MR5G7TTtbrQ4KCqrsOmLhZA8OEo1LWy79wU4Q5X', NULL, '91.84.74.250', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTh2TFFwWHJ2TjQybjlYMDVOaUx5N1BjUHhiRGdWelpxRzgxTzRwYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765537225),
('8vBcBE11ceNwvvNzU3X0jE3QtL2OHKtv5nCUUhvs', NULL, '23.234.110.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaHJoWXVaNndKSzVjdURUOEc5aVFFdGJ6ckxuV0FhS0FSRGQ4dE1JNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765562386),
('8xpZzokz6AQG2Sch4AjvgEzO1tr7zqEgqx5tEcou', NULL, '59.14.17.48', 'Mozilla/5.0 (Linux; Android 9; Mi A2 Lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVlrQk5adDBsaFo2YWJxMWR3YVJpcXd5aDAwMUUyZjY5NmVhVUlZeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765540926),
('8zw4HIWaEzUNp6th6aptH2GH2qAcLIn6M1xsCYUD', NULL, '23.27.145.166', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTJoR0l0djVDQ2dsT055cFhsRVVLRUV2SjM0RjNod0ZtRmhkT2hWbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765559258),
('96do93FtIsTitmd08qt4XxwLUZAr5KxqMYvYZcOw', NULL, '43.130.15.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWdnWGFwQk9pVWowVlR5cHQ2aktaT0E1cndwYVZCQnN0bVNDQjVybyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765551774),
('ew7eraNqXdcxKPWLETpidJpvnDVelrZAwP5g4igC', NULL, '172.236.122.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHdTOUJINmkwSXl3dTFQOVl1ajZ3RUd0azUxc3d1VUJuU0k3bVJ1MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765537610),
('hmQfrT1AwBaxHdg6jbAMrpftNQlvKY151CfPXK1n', NULL, '45.145.119.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36/Nutch-1.21-SNAPSHOT', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1hlSmM1ZjcyeWdIbjV5QVdmSVdjZUtjSE11Nk9MeWVTc0c2dWJRZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vZW1hbnAub3JnL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765543532),
('HY9ZuY3RdGo1U1O5GhdiyGtnCzoBlttQAEvHiDbu', NULL, '172.236.122.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnFxY0g5a3RnY0tZOXNZTVlhMkY3TEdHVnRqbVdkTG85bWF5V1l2cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765536843),
('IQu35LhutfvQVPVQXsvfyVJnwOCm1nrXPtw0OXDz', NULL, '176.53.220.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWxmanFWTnJuWkNXYXB2T3cwV3huOWtja3pMSU1NekE5RlkzTDhxNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765543165),
('iXtgQ3hdbB0l8DIwElEbyVrnAEeBu2U0CMtKyFHU', NULL, '43.135.142.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmV5V0lSWWR4a3pWVk5tZHd6U3A0WDV1UFVmQnRtSmhsSGpLbFNuaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZy9qb3VybmFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765573433),
('kTsAdzEqQURDnphIfceI3R3KFdbJw5KBbcYcxG91', NULL, '43.157.158.178', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3F5UEhPN0dhaDdjc0dxdzNqZ3BZem15RklzNjFlRGVRZ1FtMlE4WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765540979),
('MfZz4W4We67wnc3v4SOw1ANHQMIJLBorhhr7FhYG', NULL, '135.148.195.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/114.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFVraTVTelFHMlJDMFpEMGZIZ1ZYMnhUeFdaWkY1NFE4S09PZU8yeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765573749),
('Nv6W35WZ0p0Bsl1N776HQVVrGqfu8J1yE9Myzb3u', NULL, '59.14.17.48', 'Mozilla/5.0 (Linux; Android 9; Mi A2 Lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTDdZMkpYbmYxekFmY2Qwa1FBbG5PZjEzZmhBNldhSkNnN1V3TU5qYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765540928),
('pJZVobEc7a7Fop3D2JHQiFmsHTMTEZabdBNziJTe', NULL, '3.92.142.234', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2oyNnhQSjVFQUdyd2JDdFRseENncTJHWHcydEFHaFVpaHBVWVZTOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765556241),
('pPmOBJKXasWUDGUKegIJaxBBpwMYFFsaG4Cn94Rr', NULL, '170.106.72.178', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWtYODRjSGlMM1BwTjM1MkM3eWJHeGxZd2E0ZlhJNFNqZ2hVVlhsMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZy9qb3VybmFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765558989),
('qGqByr1VR9fy9FSYpCl7MOlUnLglwWps734MbFIx', NULL, '43.153.96.79', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUNIUHFjZU5VMmNKQkhqWHgxZTA5a3NzZlhXUTdtSVBrMmtzYzJrdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765562139),
('qR5BeP4F5gm0gpFNC5KIufqF0WhTZQSHlrXkuF90', NULL, '59.14.17.48', 'Mozilla/5.0 (Linux; Android 9; Mi A2 Lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibU1CdTFXNVRkR2RXUk1XQnNEeFd1TzhpTjBYblBFUDY1blR1UDhtYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZy9qb3VybmFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765540926),
('rjDpdQjGuODucEVeVbbgYkN0JVM0J52Kpc3AtBVG', NULL, '162.120.188.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlc0SHlQR0lLQ2hleDBrRHJYajlUOVFQM0JGd0FvcmY1cVZ4Mk5TVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765540674),
('RJTgqJQkcXIBxQ0vL6ifrXwPtupiezv8w8FKPC8c', NULL, '34.46.153.191', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:125.0) Gecko/20100101 Firefox/125.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGxVNVJUck83bWs1S1lRYk1vOWNxWDhPRDJlZ3U5UFY2Q3lpSm5SdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765547665),
('SkRM3suk4P90zykL7lY3JTp4W3S4UDKATiR4qSZp', NULL, '172.236.122.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUp1NkVBWFFsbUJ4T3pKZnE1V0p0dUNDWW9XVVV3TzVTbjc2SGZ2aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765536842),
('stNNZfDleCkBHDA9m2bkT1wT5GhogwipKjLPzn4m', NULL, '43.153.204.189', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3UxSE5XYlpJMWRvTHp2YzdkeGpJTWRIam1xR3BWSHRCQm1MbE1qdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765538486),
('tEgAls3lLTztLaCTB5sOYUyLaFJlMkr8fWUKwsac', NULL, '45.145.119.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36/Nutch-1.21-SNAPSHOT', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXBoVDUwRFVnc2hLcTdIenUwWkMwSWlUcWdyaFVFNWRpWkVtNHRiNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765572615),
('topaeWMwohZCyxLNsjajJSdcte5ViHvGWC0kD0FH', NULL, '45.145.119.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36/Nutch-1.21-SNAPSHOT', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzM2SzRqTTIxc09jdHpOeXFHYnRxSjlPYWRpTmJlSzVTMzA3WnRLZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765555707),
('VQBtWiLOSMz1MOg7yPsFK8HqNHGeUAWzV0hH8LJq', NULL, '176.53.220.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkpOdzN1WWJDUnNNVHNHMlVmWUt5NGhiNGFTTURkM2VTSm5kQVBlMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765543165),
('w3E0nbZtmq1itLk8e8NCXTn0qHP0oJFzblnh17Am', NULL, '43.130.15.147', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidjFsMkRqRVFRbXhmYml2ZTJKTXE5SENNTDJMS1JOM0xtekhUUTZlYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZy9qb3VybmFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765551775),
('wNesXGPI3AkVAwFNIUophdwvURyFABr5X1kOTPQi', NULL, '162.120.188.187', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiQ3JTSlFPUnRCYlBCOW16TEgzbWZJajV5d0VJQlpwYUp6NXdFZ05rUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765540690),
('wY5tb6ogM9KS9vWW4gZrPo4zakC1KSrkZOEi6XFV', NULL, '204.101.161.15', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlRaM2xJQVFRamNTd3hIMnRka0dsOFJhR3Qwb2QzNjJac01TUkVJSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765564548),
('X7Xh65TM0V7hSGArwyWtfEQcOOgjGSn1nzzUxvhp', NULL, '170.106.72.178', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblVNZFVrdEpNS0paZWlacFZYRUNqaTcyNFhqbGw4cWE2b0l5WnduUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHBzOi8vd3d3LmVtYW5wLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765558988),
('XW3E5turxyqjmLLG7RYhX0Afu0yydKs2byjMnb2L', NULL, '59.14.17.48', 'Mozilla/5.0 (Linux; Android 9; Mi A2 Lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkZWQllaRzVVZU9Fd2paeVk3YkoyTlhVNVhwTGhGY3g4MFdTVXRWSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765540926),
('Y4rCIcRFm0uAuHayyigGC3EGPLa95t3mOXEHtVCS', NULL, '43.153.204.189', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2tDNzZlaXc1VTRMMnRCOWdBUnU2THB5alZOUnBYNktyYnIyRUpmRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vZW1hbnAub3JnL2pvdXJuYWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765538487),
('ZtJ3woWKfmGzjGCmRZgPYNTcMXkxIExBcicFqYP2', NULL, '43.153.96.79', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnpCc2RNYlBiN0xkUkIzOVZETHdheHJkcVZWYUVVclgwSG9DQW9ZQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTc6Imh0dHBzOi8vZW1hbnAub3JnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765562138);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `abstract` text NOT NULL,
  `keywords` text DEFAULT NULL,
  `supporting_agencies` text DEFAULT NULL,
  `requirements_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `privacy_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(191) NOT NULL DEFAULT 'submitted',
  `current_stage` varchar(191) NOT NULL DEFAULT 'submission',
  `copyedit_approval_status` enum('pending','approved','changes_requested') DEFAULT NULL,
  `copyedit_author_comments` text DEFAULT NULL,
  `copyedit_approved_at` timestamp NULL DEFAULT NULL,
  `copyedit_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section` varchar(191) DEFAULT NULL,
  `journal_section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `editor_notes` text DEFAULT NULL,
  `author_comments` text DEFAULT NULL,
  `doi` varchar(191) DEFAULT NULL,
  `page_start` int(11) DEFAULT NULL,
  `page_end` int(11) DEFAULT NULL,
  `issue_id` bigint(20) UNSIGNED DEFAULT NULL,
  `submitted_at` date NOT NULL,
  `published_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `journal_id`, `user_id`, `title`, `abstract`, `keywords`, `supporting_agencies`, `requirements_accepted`, `privacy_accepted`, `status`, `current_stage`, `copyedit_approval_status`, `copyedit_author_comments`, `copyedit_approved_at`, `copyedit_approved_by`, `assigned_editor_id`, `section_editor_id`, `section`, `journal_section_id`, `editor_notes`, `author_comments`, `doi`, `page_start`, `page_end`, `issue_id`, `submitted_at`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Teseting', 'Teseting', 'Teseting ,Teseting', NULL, 1, 1, 'accepted', 'copyediting', NULL, NULL, NULL, NULL, NULL, NULL, 'Testing Submission', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-07', NULL, '2025-12-08 01:48:50', '2025-12-08 02:04:53'),
(2, 2, 1, 'Testing', 'Testing', 'Testing , TestingTesting', 'Testing', 1, 1, 'under_review', 'review', NULL, NULL, NULL, NULL, NULL, NULL, 'Testing Submission', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-07', NULL, '2025-12-08 04:19:00', '2025-12-08 04:19:57'),
(3, 2, 7, 'dd', 'dddd', 'Quiz 1', NULL, 1, 1, 'submitted', 'submission', NULL, NULL, NULL, NULL, NULL, NULL, 'Testing Submission', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-11', NULL, '2025-12-11 22:03:22', '2025-12-11 22:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `submission_authors`
--

CREATE TABLE `submission_authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `country` varchar(191) DEFAULT NULL,
  `affiliation` varchar(191) DEFAULT NULL,
  `orcid` varchar(191) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `is_corresponding` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submission_authors`
--

INSERT INTO `submission_authors` (`id`, `submission_id`, `first_name`, `last_name`, `email`, `country`, `affiliation`, `orcid`, `bio`, `order`, `is_corresponding`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'User', 'admin@journal.com', NULL, NULL, NULL, NULL, 1, 1, '2025-12-08 01:48:50', '2025-12-08 01:48:50'),
(2, 2, 'Admin', 'User', 'admin@journal.com', NULL, 'Testing', 'Testing', NULL, 1, 1, '2025-12-08 04:19:00', '2025-12-08 04:19:00'),
(3, 3, 'Arun1', 'Testing', 'arunkorath@gmail.com', NULL, 'UKB', NULL, NULL, 1, 1, '2025-12-11 22:03:22', '2025-12-11 22:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `submission_files`
--

CREATE TABLE `submission_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `file_type` varchar(191) NOT NULL,
  `file_name` varchar(191) NOT NULL,
  `file_path` varchar(191) NOT NULL,
  `original_name` varchar(191) NOT NULL,
  `mime_type` varchar(191) NOT NULL,
  `file_size` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `version_label` varchar(191) DEFAULT NULL,
  `parent_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `version_notes` text DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submission_files`
--

INSERT INTO `submission_files` (`id`, `submission_id`, `file_type`, `file_name`, `file_path`, `original_name`, `mime_type`, `file_size`, `version`, `version_label`, `parent_file_id`, `version_notes`, `is_current`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'manuscript', 'daYIL7XjWSyPow5Th0cHGqB60HM1AaOd6muWjaeY', 'submissions/1/daYIL7XjWSyPow5Th0cHGqB60HM1AaOd6muWjaeY', 'testing.docx', 'application/x-empty', 0, 1, NULL, NULL, NULL, 1, NULL, '2025-12-08 01:48:51', '2025-12-08 01:48:51'),
(2, 2, 'manuscript', 'BgJKz44FBlDwCKLZdgxPef6Iibq6Dwp5xlWP5wR1', 'submissions/2/BgJKz44FBlDwCKLZdgxPef6Iibq6Dwp5xlWP5wR1', 'testing.docx', 'application/x-empty', 0, 1, NULL, NULL, NULL, 1, NULL, '2025-12-08 04:19:00', '2025-12-08 04:19:00'),
(3, 3, 'manuscript', '5i84RzUf5HPAaGMnizfFeDoAxqiw6NSrbvFc109S.docx', 'submissions/3/5i84RzUf5HPAaGMnizfFeDoAxqiw6NSrbvFc109S.docx', '1392025_10254285.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 1434459, 1, NULL, NULL, NULL, 1, NULL, '2025-12-11 22:03:22', '2025-12-11 22:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `submission_logs`
--

CREATE TABLE `submission_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(191) NOT NULL,
  `message` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submission_logs`
--

INSERT INTO `submission_logs` (`id`, `submission_id`, `user_id`, `action`, `message`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'submitted', 'Article submitted for review', NULL, '2025-12-08 01:48:51', '2025-12-08 01:48:51'),
(2, 1, 1, 'approved_direct', 'Submission approved directly by admin. ', NULL, '2025-12-08 02:04:53', '2025-12-08 02:04:53'),
(3, 2, 1, 'submitted', 'Article submitted for review', NULL, '2025-12-08 04:19:00', '2025-12-08 04:19:00'),
(4, 2, 1, 'sent_to_review', 'Submission sent to review process. ', NULL, '2025-12-08 04:19:57', '2025-12-08 04:19:57'),
(5, 3, 7, 'submitted', 'Article submitted for review', NULL, '2025-12-11 22:03:22', '2025-12-11 22:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `affiliation` text DEFAULT NULL,
  `orcid` varchar(191) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `role` varchar(191) NOT NULL DEFAULT 'author',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notify_system` tinyint(1) NOT NULL DEFAULT 1,
  `notify_marketing` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `phone`, `affiliation`, `orcid`, `bio`, `profile_image`, `role`, `is_active`, `notify_system`, `notify_marketing`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'admin@journal.com', NULL, '$2y$12$hfmn2ya1GXTDs54sPLqk6uCvKSX0cuetJfCw9cPuW4J9/hsORm2YS', NULL, NULL, NULL, NULL, NULL, 'admin', 1, 1, 0, NULL, '2025-12-03 21:07:07', '2025-12-07 09:11:52'),
(2, 'Reviewer', 'Testing', 'review@journal.com', NULL, '$2y$12$Mj.ILNK8EJm6K1wczEs9rOtVIOP3.sq3HM5Lv0pLzpFEHCYV3FIre', NULL, 'Testing', 'Testing', NULL, NULL, 'editor', 0, 1, 0, NULL, '2025-12-08 04:45:04', '2025-12-11 18:40:58'),
(3, 'JOhn', 'Doe', 'hh@gmail.com', NULL, '$2y$12$nyU9HAe5RmNiNKPaSTX9E.isaACpXUY44gom7moGh5UZYW9.w67Fa', NULL, NULL, NULL, NULL, NULL, 'author', 1, 1, 0, NULL, '2025-12-08 22:28:40', '2025-12-08 22:28:40'),
(4, 'Main', 'Admin', 'mainadmin@emanp.org', NULL, '$2y$12$StznhNfTWEM9wLghanxQCuy/LKhL0fbOANt1YeNpBEL6epQ5SPM4q', NULL, NULL, NULL, NULL, NULL, 'admin', 1, 1, 0, 'svnvYiEBMKrrjnjTHTKvFXjuFWjt7HDC8xlAFlVmh0tZ0LXCdGiQuMbsOv5i', '2025-12-11 18:37:46', '2025-12-11 18:37:46'),
(5, 'Main', 'Editor', 'maineditor@emanp.org', NULL, '$2y$12$sppYuOlrW81wHA3ixWPvjOB1jDlCtEcQXVSdDcLmtKRoW5S2eEbtG', NULL, NULL, NULL, NULL, NULL, 'editor', 1, 1, 0, NULL, '2025-12-11 18:39:21', '2025-12-11 18:39:21'),
(6, 'Main', 'Reviewer', 'mainreviewer@emanp.org', NULL, '$2y$12$Ia8rcwcVJJ0esfu77cs24exohAfb1rncFxwQmjXAdwjB1XxJRz9Jq', NULL, NULL, NULL, NULL, NULL, 'reviewer', 1, 1, 0, 'fSiZ6aWxWTO0z2oFlAPqEWbglZWCBeTGtnyOR9uL6iMX3z7KTTl8ADQKDAf1', '2025-12-11 18:41:42', '2025-12-11 18:41:42'),
(7, 'Arun1', 'Testing', 'arunkorath@gmail.com', NULL, '$2y$12$c0MkzKm.o04MMqEH0oKBJe91XzRCwDbIrd/GyajiQUIenamuZ8tjy', NULL, 'UKB', NULL, NULL, NULL, 'author', 1, 1, 0, NULL, '2025-12-11 21:10:50', '2025-12-11 22:03:22'),
(8, 'Joh', 'Do', 'johdoe@gmail.com', NULL, '$2y$12$Vw73B2NMFaJHO8lGdyX1O.CLQq0n6s1nN/lDYDXpqbZPu/uyfoQ.q', NULL, NULL, NULL, NULL, NULL, 'reader', 1, 1, 0, NULL, '2025-12-11 21:30:58', '2025-12-11 21:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content`)),
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `location` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article_analytics`
--
ALTER TABLE `article_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_analytics_user_id_foreign` (`user_id`),
  ADD KEY `article_analytics_submission_id_event_type_created_at_index` (`submission_id`,`event_type`,`created_at`),
  ADD KEY `article_analytics_journal_id_event_type_created_at_index` (`journal_id`,`event_type`,`created_at`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `custom_pages_slug_unique` (`slug`),
  ADD KEY `custom_pages_journal_id_foreign` (`journal_id`);

--
-- Indexes for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_comments_thread_id_foreign` (`thread_id`),
  ADD KEY `discussion_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `discussion_threads`
--
ALTER TABLE `discussion_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_threads_submission_id_foreign` (`submission_id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleys`
--
ALTER TABLE `galleys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleys_submission_id_foreign` (`submission_id`),
  ADD KEY `galleys_approved_by_foreign` (`approved_by`),
  ADD KEY `galleys_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issues_journal_id_volume_issue_number_year_unique` (`journal_id`,`volume`,`issue_number`,`year`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `journals_slug_unique` (`slug`);

--
-- Indexes for table `journal_sections`
--
ALTER TABLE `journal_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_sections_section_editor_id_foreign` (`section_editor_id`),
  ADD KEY `journal_sections_journal_id_is_active_index` (`journal_id`,`is_active`);

--
-- Indexes for table `journal_users`
--
ALTER TABLE `journal_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `journal_users_journal_id_user_id_role_unique` (`journal_id`,`user_id`,`role`),
  ADD KEY `journal_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_journal_id_foreign` (`journal_id`),
  ADD KEY `payments_submission_id_foreign` (`submission_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `references`
--
ALTER TABLE `references`
  ADD PRIMARY KEY (`id`),
  ADD KEY `references_submission_id_foreign` (`submission_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_submission_id_foreign` (`submission_id`),
  ADD KEY `reviews_reviewer_id_foreign` (`reviewer_id`);

--
-- Indexes for table `review_files`
--
ALTER TABLE `review_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_files_review_id_foreign` (`review_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submissions_journal_id_foreign` (`journal_id`),
  ADD KEY `submissions_user_id_foreign` (`user_id`),
  ADD KEY `submissions_assigned_editor_id_foreign` (`assigned_editor_id`),
  ADD KEY `submissions_section_editor_id_foreign` (`section_editor_id`),
  ADD KEY `submissions_issue_id_foreign` (`issue_id`),
  ADD KEY `submissions_journal_section_id_foreign` (`journal_section_id`),
  ADD KEY `submissions_copyedit_approved_by_foreign` (`copyedit_approved_by`);

--
-- Indexes for table `submission_authors`
--
ALTER TABLE `submission_authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_authors_submission_id_foreign` (`submission_id`);

--
-- Indexes for table `submission_files`
--
ALTER TABLE `submission_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_files_submission_id_foreign` (`submission_id`),
  ADD KEY `submission_files_parent_file_id_foreign` (`parent_file_id`);

--
-- Indexes for table `submission_logs`
--
ALTER TABLE `submission_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_logs_submission_id_foreign` (`submission_id`),
  ADD KEY `submission_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `widgets_journal_id_foreign` (`journal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_analytics`
--
ALTER TABLE `article_analytics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_threads`
--
ALTER TABLE `discussion_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galleys`
--
ALTER TABLE `galleys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `journal_sections`
--
ALTER TABLE `journal_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `journal_users`
--
ALTER TABLE `journal_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_files`
--
ALTER TABLE `review_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_authors`
--
ALTER TABLE `submission_authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_files`
--
ALTER TABLE `submission_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_logs`
--
ALTER TABLE `submission_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_analytics`
--
ALTER TABLE `article_analytics`
  ADD CONSTRAINT `article_analytics_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_analytics_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_analytics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD CONSTRAINT `custom_pages_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_comments`
--
ALTER TABLE `discussion_comments`
  ADD CONSTRAINT `discussion_comments_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `discussion_threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_threads`
--
ALTER TABLE `discussion_threads`
  ADD CONSTRAINT `discussion_threads_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galleys`
--
ALTER TABLE `galleys`
  ADD CONSTRAINT `galleys_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `galleys_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `galleys_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_sections`
--
ALTER TABLE `journal_sections`
  ADD CONSTRAINT `journal_sections_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_sections_section_editor_id_foreign` FOREIGN KEY (`section_editor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `journal_users`
--
ALTER TABLE `journal_users`
  ADD CONSTRAINT `journal_users_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `references`
--
ALTER TABLE `references`
  ADD CONSTRAINT `references_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_files`
--
ALTER TABLE `review_files`
  ADD CONSTRAINT `review_files_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_assigned_editor_id_foreign` FOREIGN KEY (`assigned_editor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_copyedit_approved_by_foreign` FOREIGN KEY (`copyedit_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_journal_section_id_foreign` FOREIGN KEY (`journal_section_id`) REFERENCES `journal_sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_section_editor_id_foreign` FOREIGN KEY (`section_editor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submission_authors`
--
ALTER TABLE `submission_authors`
  ADD CONSTRAINT `submission_authors_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submission_files`
--
ALTER TABLE `submission_files`
  ADD CONSTRAINT `submission_files_parent_file_id_foreign` FOREIGN KEY (`parent_file_id`) REFERENCES `submission_files` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `submission_files_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submission_logs`
--
ALTER TABLE `submission_logs`
  ADD CONSTRAINT `submission_logs_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submission_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `widgets`
--
ALTER TABLE `widgets`
  ADD CONSTRAINT `widgets_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
