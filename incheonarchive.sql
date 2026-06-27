-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 26-06-27 16:09
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `incheonarchive`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `bans`
--

CREATE TABLE `bans` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `bans`
--

INSERT INTO `bans` (`idx`, `user_idx`, `date`, `type`) VALUES
(3, 4, '2026-07-03', 'post'),
(8, 4, '2026-06-30', 'debate');

-- --------------------------------------------------------

--
-- 테이블 구조 `blocks`
--

CREATE TABLE `blocks` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `target_user_idx` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `comments`
--

CREATE TABLE `comments` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `post_idx` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `comments_likes`
--

CREATE TABLE `comments_likes` (
  `idx` int(11) NOT NULL,
  `comment_idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `post_idx` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `debates`
--

CREATE TABLE `debates` (
  `idx` int(11) NOT NULL,
  `title` varchar(400) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `result` int(11) DEFAULT NULL,
  `user_idx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `debates`
--

INSERT INTO `debates` (`idx`, `title`, `date`, `result`, `user_idx`) VALUES
(1, '엉덩이는 두개인가 하나인가', '2026-06-22 11:49:45', NULL, 2),
(2, '꺅두기는 성이 꺅이고 이름이 두기이다', '2026-06-23 09:02:53', NULL, 2),
(5, '똥은 왜 이름이 똥인가', '2026-06-26 11:14:39', NULL, 5),
(6, '닭이 먼저인가 알이 먼저인가 미노타우르스가 먼저인가', '2026-06-26 11:15:19', NULL, 4),
(7, '졸릴 땐 자야하는가', '2026-06-27 02:06:11', NULL, 3);

-- --------------------------------------------------------

--
-- 테이블 구조 `debate_opinions`
--

CREATE TABLE `debate_opinions` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `debate_idx` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `debate_opinions`
--

INSERT INTO `debate_opinions` (`idx`, `user_idx`, `debate_idx`, `content`, `date`) VALUES
(1, 2, 1, '당연히 두개죠...ㄷㄷ', '2026-06-23 10:51:48'),
(3, 2, 1, '음...', '2026-06-23 11:20:50'),
(10, 2, 1, 'ㅇㄹㄹㄹㄹㄹㄹㄹㄹㄹㄹ', '2026-06-23 11:29:28'),
(13, 3, 7, '당연하지', '2026-06-27 02:15:05'),
(14, 4, 6, '닭이지 ㅋㅋ', '2026-06-27 13:41:51');

-- --------------------------------------------------------

--
-- 테이블 구조 `follows`
--

CREATE TABLE `follows` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `target_user_idx` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `follows`
--

INSERT INTO `follows` (`idx`, `user_idx`, `target_user_idx`, `date`) VALUES
(3, 2, 1, '2026-06-25 16:49:58');

-- --------------------------------------------------------

--
-- 테이블 구조 `inquires`
--

CREATE TABLE `inquires` (
  `idx` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(400) NOT NULL,
  `public` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `inquires`
--

INSERT INTO `inquires` (`idx`, `title`, `content`, `date`, `img`, `public`, `user_idx`, `answer`) VALUES
(1, '인천 아카이브 이름 구려요', 'ㅈㄱㄴ', '2026-06-24 18:03:06', '/asset/inquires/구치파치.webp', 1, 2, '저도 압니다...'),
(2, '비공개 게시글이 있으면', 'be 공개 게시글도 있나 ㅋㅋ', '2026-06-24 18:03:32', '', 0, 2, NULL),
(3, '문의사항 입니다!!!!', 'ㅁㅇㅅㅎ!', '2026-06-27 22:58:39', '/asset/inquires/꺅두기.png', 1, 4, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `inquire_comments`
--

CREATE TABLE `inquire_comments` (
  `idx` int(11) NOT NULL,
  `inquire_idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `inquire_comments`
--

INSERT INTO `inquire_comments` (`idx`, `inquire_idx`, `user_idx`, `content`, `date`) VALUES
(3, 1, 2, '우와 구치파치다!', '2026-06-24 19:33:59');

-- --------------------------------------------------------

--
-- 테이블 구조 `likes`
--

CREATE TABLE `likes` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `post_idx` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `likes`
--

INSERT INTO `likes` (`idx`, `user_idx`, `post_idx`, `date`) VALUES
(28, 5, 13, '2026-06-26 11:39:46');

-- --------------------------------------------------------

--
-- 테이블 구조 `opinions`
--

CREATE TABLE `opinions` (
  `idx` int(11) NOT NULL,
  `user_idx` int(11) NOT NULL,
  `debate_idx` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `opinions`
--

INSERT INTO `opinions` (`idx`, `user_idx`, `debate_idx`, `type`, `date`) VALUES
(1, 2, 1, 1, '2026-06-23 10:53:20'),
(6, 2, 2, 1, '2026-06-23 10:29:19'),
(14, 3, 7, 1, '2026-06-27 02:06:15'),
(15, 4, 6, 1, '2026-06-27 13:41:48');

-- --------------------------------------------------------

--
-- 테이블 구조 `posts`
--

CREATE TABLE `posts` (
  `idx` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `detail` text NOT NULL,
  `photo` varchar(400) NOT NULL,
  `user_idx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`idx`, `title`, `category`, `date`, `detail`, `photo`, `user_idx`) VALUES
(9, 'ㅎㅇ용', '정보', '2026-06-25 17:09:41', 'ㅋㅋ', '', 2),
(10, '야 똥 싸라', '먹거리', '2026-06-26 19:48:22', '똥을 싸면 건강에 좋다', '', 4),
(12, '전주 비빔밥보다 더 신선한 비빔밥은?', '정보', '2026-06-26 20:33:39', '이번주 비빔밥..ㅋㅋ', '', 5),
(13, '샹크스가 여자인 이유는?????????????????????????', '먹거리', '2026-06-26 20:34:16', '암 컷 (arm cut) 이라서 ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ', '/asset/posts/wo78o84x7wxmmc4f8m83.jpg', 5);

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `idx` int(11) NOT NULL,
  `id` varchar(300) NOT NULL,
  `pw` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `profile` varchar(400) NOT NULL,
  `type` varchar(11) NOT NULL DEFAULT 'general',
  `login_token` varchar(200) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`idx`, `id`, `pw`, `name`, `profile`, `type`, `login_token`, `date`) VALUES
(2, 'admin', '1234', '관리자', '/asset/profile/귀여운 두기.tmp', 'admin', NULL, '2026-06-25 18:57:32'),
(3, 'sihu', '1234', '시후', '/asset/profile/꺅두기.png', 'post', 'c8c3446254d3e99bf18aed0f6689525b80b64ac176f98c58582c802ddbe60096', '2026-06-25 19:50:16'),
(4, 'user1', '1234', '유저1', '/asset/profile/구치파치.webp', 'general', '9324622da8e44a683a07014309faf6361cd2270f07740111b3fd1c94d68f95db', '2026-06-26 19:40:30'),
(5, 'user2', '1234', '유저2', '/asset/profile/대회.png', 'debate', '782141672652809ffa8cfcaac77e04ed018c17c2462b94030e3eb5df0f59c2b5', '2026-06-26 19:47:35');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`),
  ADD KEY `post_idx` (`post_idx`);

--
-- 테이블의 인덱스 `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`),
  ADD KEY `comment_idx` (`comment_idx`),
  ADD KEY `post_idx` (`post_idx`);

--
-- 테이블의 인덱스 `debates`
--
ALTER TABLE `debates`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `debate_opinions`
--
ALTER TABLE `debate_opinions`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`),
  ADD KEY `debate_idx` (`debate_idx`);

--
-- 테이블의 인덱스 `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `inquires`
--
ALTER TABLE `inquires`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `inquire_comments`
--
ALTER TABLE `inquire_comments`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `post_idx` (`post_idx`);

--
-- 테이블의 인덱스 `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`),
  ADD KEY `debate_idx` (`debate_idx`);

--
-- 테이블의 인덱스 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `user_idx` (`user_idx`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `bans`
--
ALTER TABLE `bans`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `blocks`
--
ALTER TABLE `blocks`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `comments_likes`
--
ALTER TABLE `comments_likes`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 테이블의 AUTO_INCREMENT `debates`
--
ALTER TABLE `debates`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `debate_opinions`
--
ALTER TABLE `debate_opinions`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 테이블의 AUTO_INCREMENT `follows`
--
ALTER TABLE `follows`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `inquires`
--
ALTER TABLE `inquires`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `inquire_comments`
--
ALTER TABLE `inquire_comments`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 테이블의 AUTO_INCREMENT `opinions`
--
ALTER TABLE `opinions`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`post_idx`) REFERENCES `posts` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD CONSTRAINT `comments_likes_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_likes_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_likes_ibfk_3` FOREIGN KEY (`comment_idx`) REFERENCES `comments` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_likes_ibfk_4` FOREIGN KEY (`post_idx`) REFERENCES `posts` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `debates`
--
ALTER TABLE `debates`
  ADD CONSTRAINT `debates_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debates_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debates_ibfk_3` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debates_ibfk_4` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `debate_opinions`
--
ALTER TABLE `debate_opinions`
  ADD CONSTRAINT `debate_opinions_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debate_opinions_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debate_opinions_ibfk_3` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `debate_opinions_ibfk_4` FOREIGN KEY (`debate_idx`) REFERENCES `debates` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `inquires`
--
ALTER TABLE `inquires`
  ADD CONSTRAINT `inquires_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `inquires_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `inquire_comments`
--
ALTER TABLE `inquire_comments`
  ADD CONSTRAINT `inquire_comments_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_idx`) REFERENCES `posts` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `opinions`
--
ALTER TABLE `opinions`
  ADD CONSTRAINT `opinions_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `opinions_ibfk_4` FOREIGN KEY (`debate_idx`) REFERENCES `debates` (`idx`) ON DELETE CASCADE;

--
-- 테이블의 제약사항 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_idx`) REFERENCES `users` (`idx`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
