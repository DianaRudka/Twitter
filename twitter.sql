-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 11 Lis 2016, 19:08
-- Wersja serwera: 5.7.16-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `commentary` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `tweet_id`, `commentary`, `user_id`, `comment_date`) VALUES
(1, 6, 'jaki ładny tweet', 29, 1478007881),
(2, 30, 'sad', 32, 1478120806),
(3, 26, 'bla bla jfskjjsnv', 32, 1478120834),
(4, 26, 'bla bla jfskjjsnv', 32, 1478121312),
(5, 26, 'bla bla jfskjjsnv', 32, 1478121342),
(6, 26, 'bla bla jfskjjsnv', 32, 1478121546),
(7, 26, 'bla bla jfskjjsnv', 32, 1478121582),
(8, 30, 'blablablkdvb jcfuabc', 32, 1478122638),
(9, 30, 'blablablkdvb jcfuabc', 32, 1478122750),
(10, 32, 'super', 32, 1478285656),
(11, 32, 'super', 32, 1478285690),
(14, 35, 'blabhefbh shebfhe bhsb', 41, 1478434457);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `creation_date` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `msg_status` tinyint(1) NOT NULL,
  `replay_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `creation_date`, `sender_id`, `receiver_id`, `message`, `msg_status`, `replay_to`) VALUES
(1, 1477997638, 28, 29, 'blablabla sjdbfjs jsfbsj sjfbsefe ejsbfej ejeuhfsnv sjsie efheifh sjhrfhei efsjks euhff ejfbsjk jrdkkjg rjgndjrig ', 1, 0),
(2, 1477997700, 28, 29, 'blablabla sjdbfjs jsfbsj sjfbsefe ejsbfej ejeuhfsnv sjsie efheifh sjhrfhei efsjks euhff ejfbsjk jrdkkjg rjgndjrig ', 1, 0),
(3, 1477999638, 28, 29, 'blablabla sjdbfjs jsfbsj sjfbsefe ejsbfej ejeuhfsnv sjsie efheifh sjhrfhei efsjks euhff ejfbsjk jrdkkjg rjgndjrig ', 1, 0),
(4, 1477919638, 41, 36, 'blablabla sjdbfjs jsfbsj sjfbsefe ejsbfej ejeuhfsnv sjsie efheifh sjhrfhei efsjks euhff ejfbsjk jrdkkjg rjgndjrig ', 1, 0),
(5, 1477997800, 29, 41, 'jakas wiadomosc', 0, 0),
(6, 1478813103, 32, 41, 'cos tu wpisze ', 0, 0),
(7, 1478813305, 32, 29, 'znowu napisalam wiadomosc', 1, 0),
(8, 1478876494, 41, 29, 'odpisuje na wiadomosc od Marka\r\n\r\nW dniu 01-11-2016, 11:56:40 uÅ¼ytkownik Marek napisaÅ‚:\r\njakas wiadomosc', 1, 5),
(9, 1478876668, 41, 28, 'czesc co slychac?', 0, 0),
(10, 1478876771, 28, 41, 'calkiem spoko, duzo pracy z php\r\nW dniu 11-11-2016, 16:04:28 uÅ¼ytkownik Waldek napisaÅ‚:\r\nczesc co slychac?', 1, 9);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `creation_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `tweets`
--

INSERT INTO `tweets` (`id`, `user_id`, `tweet`, `creation_date`) VALUES
(1, 28, 'Hello! Its my first tweet', 1477918563),
(2, 28, 'Hello! Its my first tweet', 1477990000),
(3, 28, 'Hello! Whats new with u', 1477997560),
(4, 28, 'Hello! Whats new with u', 1477997638),
(5, 28, 'Hello! Whats new with u', 1477997687),
(6, 29, 'Hello! Im fine', 1477997881),
(7, 29, 'Cool app, check it out', 1477998134),
(8, 28, 'halo halo cantralo', 1478086050),
(9, 28, 'halo halo cantralo', 1478086062),
(10, 28, 'halo halo cantralo', 1478086195),
(11, 28, 'halo halo cantralo', 1478086236),
(12, 28, 'halo halo cantralo', 1478086324),
(13, 28, 'halo halo cantralo', 1478086340),
(14, 28, 'halo halo cantralo', 1478086365),
(15, 28, 'halo halo cantralo', 1478086381),
(16, 28, 'halo halo cantralo', 1478087085),
(17, 28, 'halo halo cantralo', 1478087134),
(18, 28, 'halo halo cantralo', 1478088320),
(19, 28, 'halo halo cantralo', 1478088345),
(20, 28, 'halo halo cantralo', 1478089108),
(21, 28, 'halo halo cantralo', 1478089110),
(22, 28, 'halo halo cantralo', 1478089111),
(23, 28, 'halo halo cantralo', 1478089166),
(24, 28, 'halo halo cantralo', 1478089167),
(25, 28, 'halo halo cantralo', 1478089182),
(26, 28, 'halo halo cantralo', 1478089182),
(27, 28, 'halo halo cantralo', 1478089205),
(28, 28, 'halo halo cantralo', 1478089302),
(29, 28, 'halo halo cantralo', 1478089502),
(30, 32, 'to jest pierwszy tweet asi', 1478111045),
(31, 29, 'nowy tweet bla bla bla', 1478111725),
(32, 36, 'nowy uÅ¼ytkownik na twitterze', 1478112027),
(33, 32, 'shdbjhs sdhbse sdfbs sdefbd', 1478285714),
(35, 32, 'fbhaebf aefbehbahf aebfaheb ajhdjjwinddh degte', 1478382832),
(36, 41, 'cos wpisujemy w pole tweet', 1478434433),
(37, 41, 'jakas wiadomosc', 1478789182);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `hashedPassword` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `hashedPassword`, `email`) VALUES
(28, 'Diana', '$2y$10$bPWeTx1g3QnHevZou9/jWeHLpAuqu3TKq09SsK2Sp9npUJLtCN.6O', 'a@b.pl'),
(29, 'Marek', '$2y$10$mOmJYSphXDWP7W99iOTrbeEPdMEPvmQhq2v8saDG6hJGGtrZk/fLm', 'm@b.pl'),
(31, 'Gosia', '$2y$10$xlzTZCSXEbqpqFHXF4Inq.qTXXigsfWe7JXzSPa9DyzAovckhyit6', 'g@b.pl'),
(32, 'Asia', '$2y$10$aTa2tGKm89g5dc0CyY0TaO/ZrBjosm3N90VGRNvlGah4.ipqq4nNi', 'd@a.pl'),
(36, 'Zosia', '$2y$10$wqITOSwDggsWrWXCKsD7keNU9/BFd0QfFLDTiEa4bnyr4TkrwW2jK', 'z@a.pl'),
(38, 'Mania', '$2y$10$SHsrgHGvlj4EvBsimjSFB.M90.C5BtbeycmYyO7GrWDN.9xWMknqG', 'm@a.pl'),
(41, 'Waldek', '$2y$10$.MksRzYhlddeTJ2V8wG80upI2URlnIU.5DASGFwBgC5tMfvOU.22C', 'w@a.pl'),
(42, 'Marcin', '$2y$10$ev0hCQn9M1kNJikaPZn2zuD5AIefLOFJhYsMkdERVYUApm5xgXETK', 's@a.pl'),
(43, 'MarcinP', '$2y$10$C.SyqhOScRuLPkiuQCjNA.wGd50XYzREj364GLkV/SQ6z2VTTJA0q', 'q@a.pl'),
(44, 'Rdbcs', '$2y$10$NFNn8JrQUjycdHH/zBBvNObrTlBdI1kuWa3wChpPMdMItirXR9BWq', 'o@a.pl'),
(45, 'duksd', '$2y$10$IjpVwJWHL/90uae964g0e.inK5ocfaQcb7DrFc/HZd6UOqSE2n2sW', 'p@a.pl');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet_id` (`tweet_id`),
  ADD KEY `comments_ibfk_2` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `tweets`
--
ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
