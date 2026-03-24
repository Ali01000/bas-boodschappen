-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 16 apr 2024 om 22:46
-- Serverversie: 10.4.22-MariaDB
-- PHP-versie: 8.1.2

-- Tabelstructuur voor tabel `artikelen`

CREATE TABLE `artikelen` (
  `artikelId` int(11) NOT NULL,
  `artikelNaam` varchar(100) NOT NULL,
  `artikelPrijs` decimal(10,2) NOT NULL,
  `artikelBeschrijving` text,
  `artikelVoorraad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `artikelen`
--

INSERT INTO `artikelen` (`artikelId`, `artikelNaam`, `artikelPrijs`, `artikelBeschrijving`, `artikelVoorraad`) VALUES
(1, 'Appels', 2.50, 'Verse appels per kg', 100),
(2, 'Brood', 1.80, 'Wit brood', 50),
(3, 'Melk', 1.20, 'Volle melk 1L', 30);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikelen`
--
ALTER TABLE `artikelen`
  ADD PRIMARY KEY (`artikelId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikelen`
--
ALTER TABLE `artikelen`
  MODIFY `artikelId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;