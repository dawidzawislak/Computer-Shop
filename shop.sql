-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Kwi 2022, 12:13
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admini`
--

CREATE TABLE `admini` (
  `id_admina` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `haslo` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `admini`
--

INSERT INTO `admini` (`id_admina`, `login`, `haslo`) VALUES
(1, 'admin', '$2y$10$IcVNb7xdgtSu2dPTH8Gf/uJdCmIuxN/Hrr35uwlLQTYRogqYv6YaO');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dyski`
--

CREATE TABLE `dyski` (
  `id_dysk` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `pojemnosc` int(11) NOT NULL,
  `technologia` varchar(4) NOT NULL,
  `interfejs` varchar(25) NOT NULL,
  `rodzaj_kosci_pamieci` varchar(3) DEFAULT NULL,
  `predkosc_odczytu` int(11) NOT NULL,
  `predkosc_zapisu` int(11) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `dyski`
--

INSERT INTO `dyski` (`id_dysk`, `firma`, `model`, `pojemnosc`, `technologia`, `interfejs`, `rodzaj_kosci_pamieci`, `predkosc_odczytu`, `predkosc_zapisu`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'Toshiba', 'P300', 1024, 'HDD', 'SATA III', NULL, 170, 170, 175, 5, 'disk/toshibap300.jpg'),
(2, 'ADATA', 'HD650', 1024, 'HDD', 'USB 3.1', NULL, 130, 130, 239, 33, 'disk/Adata HD650.jpg'),
(3, 'Crucial', 'SATA SSD MX500', 500, 'SSD', 'SATA III', 'TLC', 560, 510, 269, 99, 'disk/Crucial mx500.png'),
(4, 'Samsung', 'SATA SSD 860 EVO', 500, 'SSD', 'SATA III', 'TLC', 550, 520, 299, 152, 'disk/Samsung 860 EVO.jfif'),
(5, 'Seagate ', 'BARRACUDA ', 2048, 'HDD', 'SATA III', NULL, 210, 210, 239, 38, 'disk/Seagate BarraCuda.jpg'),
(6, 'WD', 'BLUE', 1024, 'HDD', 'SATA III', NULL, 155, 150, 219, 72, 'disk/WD BLUE.jpg'),
(7, 'GOODRAM ', 'IRDM PRO', 512, 'SSD', 'SATA III', 'TLC', 555, 540, 319, 27, 'disk/GoodRam IRDM PRO.jpg'),
(8, 'ADATA ', 'XPG SX8200 Pro', 512, 'SSD', 'PCIe x4 NVMe', NULL, 3500, 2300, 312, 23, 'disk/Adata XPG SX8200 Pro.jpg'),
(9, 'SAMSUNG ', '870 Qvo', 1024, 'SSD', 'SATA III', 'QLC', 560, 530, 449, 54, 'disk/Samsung 870 Qvo.png'),
(10, 'WD', 'Elements SE', 4096, 'HDD', 'USB 3.0', NULL, 410, 380, 399, 30, 'disk/WD Elements SE.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karty_graficzne`
--

CREATE TABLE `karty_graficzne` (
  `id_GPU` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(40) NOT NULL,
  `pamiec` int(11) NOT NULL,
  `rodzaj_pamieci` varchar(10) NOT NULL,
  `zlacza` varchar(45) NOT NULL,
  `TDP` int(11) NOT NULL,
  `pobor_mocy` int(11) NOT NULL,
  `rdzenie_CUDA` int(11) DEFAULT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `karty_graficzne`
--

INSERT INTO `karty_graficzne` (`id_GPU`, `firma`, `model`, `pamiec`, `rodzaj_pamieci`, `zlacza`, `TDP`, `pobor_mocy`, `rdzenie_CUDA`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'Nvidia', 'GTX 1650', 4, 'GDDR6', 'HDMI, DisplayPort', 75, 140, 896, 759, 5, 'gpu/gtx1650.jpg'),
(2, 'AMD', 'MSI RADEON RX 5500 XT MECH OC', 4, 'GDDR6', 'HDMI, DisplayPort', 130, 200, NULL, 889, 4, 'gpu/rx5500xt.jpg'),
(3, 'Nvidia', 'Zotac GeForce RTX 2060 ', 6, 'GDDR6', 'HDMI, DisplayPort', 160, 230, 1920, 1459, 57, 'gpu/rtx2060.jpg'),
(4, 'MSI', 'RTX 2070 SUPER GAMING X TRIO', 8, 'GDDR6', 'HDMI, DisplayPort', 215, 280, 2560, 2459, 52, 'gpu/rtx2070.jpg'),
(5, 'Nvidia', 'KFA2 GeForce RTX 3090 HOF', 24, 'GDDR6X', 'HDMI, DisplayPort ', 350, 420, 10496, 15199, 4, 'gpu/rtx3090.jpg'),
(6, 'Nvidia', 'PNY Quadro RTX 4000', 8, 'GDDR6', 'DisplayPort,  USB-C', 125, 160, 2304, 4899, 12, 'gpu/rtx4000.png'),
(7, 'AMD', 'XFX Radeon RX 580 GTS XXX Edition OC+', 8, 'GDDR5', 'HDMI,  DVI-D, DisplayPort ', 185, 250, NULL, 2949, 51, 'gpu/rx580.jpg'),
(8, 'AMD', 'MSI Radeon RX 6700 XT MECH 2X', 12, 'GDDR6', 'HDMI, DisplayPort ', 230, 430, NULL, 4999, 3, 'gpu/rx6700xt.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(25) NOT NULL,
  `nazwisko` varchar(25) NOT NULL,
  `telefon` int(9) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `miasto` varchar(25) DEFAULT NULL,
  `kod_pocztowy` varchar(6) DEFAULT NULL,
  `adres` varchar(50) DEFAULT NULL,
  `ilosc_zamowien` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `imie`, `nazwisko`, `telefon`, `email`, `login`, `haslo`, `miasto`, `kod_pocztowy`, `adres`, `ilosc_zamowien`) VALUES
(1, 'Dawid', 'Zawiślak', 123123123, 'dzawislak@gmail.com', 'dawidz123', '$2y$10$5xIjfvlG9GQp8WHZhKc1dOx.VzaDZMBJpE1ul7iA996g.SFgf5d2W', 'Łuzna', '38-322', 'Łużna 21321', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obudowy`
--

CREATE TABLE `obudowy` (
  `id_obudowa` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `typ` varchar(25) NOT NULL,
  `standard_plyty` varchar(25) NOT NULL,
  `rgb` tinyint(1) NOT NULL,
  `wentylator` tinyint(1) NOT NULL,
  `ilosc_kieszeni_dysk` int(11) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `obudowy`
--

INSERT INTO `obudowy` (`id_obudowa`, `firma`, `model`, `typ`, `standard_plyty`, `rgb`, `wentylator`, `ilosc_kieszeni_dysk`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'iBOX', 'VESTA S07', 'Middle Tower', 'ATX, mATX', 0, 0, 5, 79, 50, 'case/iBox VESTA S07.jpg'),
(2, 'Zalman', 'ZM-T3', 'Mini Tower', 'mATX, Mini-ITX', 0, 1, 6, 119, 82, 'case/Zalman ZM-T3.jpg'),
(3, 'SilentiumPC', 'Signum SG1V EVO TG ARGB', 'Middle Tower', 'ATX,Mini-ITX', 1, 1, 4, 259, 23, 'case/SilentiumPC Signum SG1V EVO TG ARGB.jpg'),
(4, 'KRUX', 'ASTRAL', 'Middle Tower', 'ATX,Mini-ITX', 1, 1, 6, 159, 0, 'case/Krux ASTRAL.jpg'),
(5, 'SilentiumPC', 'Armis AR7', 'Middle Tower', 'ATX, mATX, Mini-ITX', 0, 1, 11, 359, 11, 'case/Silentium Armis AR7.jpg'),
(6, 'be quiet!', 'Pure Base 600', 'Middle Tower', 'ATX, mATX, Mini-ITX', 0, 1, 13, 429, 16, 'case/be quiet Pure Base 600.jpg'),
(7, 'Genesis ', 'TITAN 700', 'Middle Tower', 'ATX, mATX, Mini-ITX', 1, 1, 4, 169, 32, 'case/genesis TITAN 700.jpg'),
(8, 'Thermaltake ', 'Core W100', 'Super Tower', 'ATX,Mini-ITX,XL-ATX,EATX', 0, 0, 13, 1549, 2, 'case/thermaltake Core W100.jpg'),
(9, 'Thermaltake ', 'Core P3 Curved Edition', 'Open-Air Tower', 'ATX,Mini-ITX,mATX', 0, 0, 4, 879, 6, 'case/thermaltake Core P3 Curved Edition.jfif');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plyty_glowne`
--

CREATE TABLE `plyty_glowne` (
  `id_MOBO` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `socket` varchar(10) NOT NULL,
  `sloty_pcie` int(11) NOT NULL,
  `sloty_ram` int(11) NOT NULL,
  `format` varchar(10) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `plyty_glowne`
--

INSERT INTO `plyty_glowne` (`id_MOBO`, `firma`, `model`, `socket`, `sloty_pcie`, `sloty_ram`, `format`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'MSI', 'B450 TOMAHAWK MAX', 'AM4', 4, 4, 'ATX', 589, 125, 'mobo/MSI B450 TOMAHAWK MAX.png'),
(2, 'Gigabyte ', 'B450M S2H', 'AM4', 3, 2, 'mATX', 329, 115, 'mobo/Gigabyte B450M S2H.jpg'),
(3, 'MSI', 'B450M-A PRO MAX', 'AM4', 2, 2, 'mATX', 359, 122, 'mobo/Msi B450M-A PRO MAX.jpg'),
(4, 'MSI', 'B460M-A PRO', '1200', 2, 2, 'mATX', 319, 97, 'mobo/Msi B460M-A PRO.jpg'),
(5, 'MSI ', 'MPG Z490 GAMING PLUS', '1200', 4, 4, 'ATX', 799, 13, 'mobo/Msi MPG Z490 GAMING PLUS.png'),
(6, 'ASUS ', 'ROG STRIX B450-F GAMING', 'AM4', 6, 4, 'ATX', 649, 2, 'mobo/Asus ROG STRIX B450-F GAMING.jpg'),
(7, 'Gigabyte ', 'X570 AORUS ELITE', 'AM4', 4, 4, 'ATX', 949, 15, 'mobo/Gigabyte X570 AORUS ELITE.jpg'),
(8, 'Gigabyte ', 'B365M D3H', '1151', 3, 4, 'mATX', 379, 15, 'mobo/Gigabyte B365M D3H.jpg'),
(9, 'ASUS ', 'TUF GAMING B560M-PLUS WIF', '1200', 3, 4, 'mATX', 679, 16, 'mobo/Asus TUF GAMING B560M-PLUS WIFI.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `procesory`
--

CREATE TABLE `procesory` (
  `id_CPU` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `socket` varchar(15) NOT NULL,
  `taktowanie` float NOT NULL,
  `ilosc_rdzeni` int(11) NOT NULL,
  `TDP` int(3) NOT NULL,
  `pobor_mocy` int(11) NOT NULL,
  `chlodzenie_box` tinyint(1) NOT NULL,
  `odblokowany_mnoznik` tinyint(1) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `procesory`
--

INSERT INTO `procesory` (`id_CPU`, `firma`, `model`, `socket`, `taktowanie`, `ilosc_rdzeni`, `TDP`, `pobor_mocy`, `chlodzenie_box`, `odblokowany_mnoznik`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'Intel ', 'i5-10400F', '1200', 2.9, 6, 65, 120, 1, 0, 719, 16, 'cpu/i5-10400F.jpg'),
(2, 'Intel ', 'i5-10400', '1200', 2.9, 6, 65, 120, 1, 0, 799, 121, 'cpu/i5-10400.jpg'),
(3, 'Intel ', 'i5-10600', '1200', 3.3, 6, 65, 120, 1, 0, 1049, 320, 'cpu/i5-10600.jpg'),
(4, 'Intel', 'i5-9400F', '1151', 2.9, 6, 65, 120, 1, 0, 699, 8, 'cpu/i5-9400F.jfif'),
(5, 'AMD ', 'Ryzen 5 3600', 'AM4', 3.6, 6, 65, 120, 1, 1, 869, 45, 'cpu/Ryzen 5 3600.jpg'),
(6, 'AMD ', 'Ryzen 5 5600X', 'AM4', 3.7, 6, 65, 120, 1, 1, 1449, 22, 'cpu/Ryzen 5 5600X.jpg'),
(7, 'AMD ', 'Ryzen 5 3400G', 'AM4', 3.7, 4, 65, 120, 1, 1, 879, 10, 'cpu/Ryzen 5 3400G.png'),
(8, 'AMD ', 'Ryzen 7 3800X', 'AM4', 3.9, 8, 105, 160, 1, 1, 1399, 24, 'cpu/Ryzen 7 3800X.png'),
(9, 'Intel', 'i7-9700F', '1151', 3, 8, 65, 120, 1, 0, 1179, 12, 'cpu/i7-9700F.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produkty` int(11) NOT NULL,
  `id_CPU` int(11) DEFAULT NULL,
  `id_GPU` int(11) DEFAULT NULL,
  `id_RAM` int(11) DEFAULT NULL,
  `id_dysk1` int(11) DEFAULT NULL,
  `id_dysk2` int(11) DEFAULT NULL,
  `id_MOBO` int(11) DEFAULT NULL,
  `id_PSU` int(11) DEFAULT NULL,
  `id_obudowa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produkty`, `id_CPU`, `id_GPU`, `id_RAM`, `id_dysk1`, `id_dysk2`, `id_MOBO`, `id_PSU`, `id_obudowa`) VALUES
(1, 6, 5, 7, 9, 10, 7, 6, 8);

--
-- Wyzwalacze `produkty`
--
DELIMITER $$
CREATE TRIGGER `ilosc_cpu` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM procesory WHERE id_CPU = new.id_CPU) < 1) THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Brak procesora';
ELSE
	UPDATE procesory
	SET procesory.ilosc_sztuk = (procesory.ilosc_sztuk - 1)
	WHERE id_CPU = new.id_CPU;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_dysk1` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM dyski WHERE id_dysk = new.id_dysk1) < 1) THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Brak dysku';
ELSE
	UPDATE dyski
	SET dyski.ilosc_sztuk = (dyski.ilosc_sztuk - 1)
	WHERE id_dysk = new.id_dysk1;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_dysk2` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM dyski WHERE id_dysk = new.id_dysk2) < 1) THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Brak dysku';
ELSE
	UPDATE dyski
	SET dyski.ilosc_sztuk = (dyski.ilosc_sztuk - 1)
	WHERE id_dysk = new.id_dysk2;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_gpu` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM karty_graficzne WHERE id_GPU = new.id_GPU) < 1) THEN
	SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = 'Brak gpu';
ELSE
	UPDATE karty_graficzne
	SET karty_graficzne.ilosc_sztuk = (karty_graficzne.ilosc_sztuk - 1)
	WHERE id_GPU = new.id_GPU;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_mobo` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM plyty_glowne WHERE id_MOBO = new.id_MOBO) < 1) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Brak MOBO';
ELSE
    UPDATE plyty_glowne
    SET plyty_glowne.ilosc_sztuk = (plyty_glowne.ilosc_sztuk - 1)
    WHERE id_MOBO = new.id_MOBO;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_obu` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM obudowy WHERE id_obudowa = new.id_obudowa) < 1) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Brak obudowy';
ELSE
    UPDATE obudowy
    SET obudowy.ilosc_sztuk = (obudowy.ilosc_sztuk - 1)
    WHERE id_obudowa = new.id_obudowa;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_psu` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM zasilacze WHERE id_PSU = new.id_PSU) < 1) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Brak zasilacza';
ELSE
    UPDATE zasilacze
    SET zasilacze.ilosc_sztuk = (zasilacze.ilosc_sztuk - 1)
    WHERE id_PSU = new.id_PSU;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_ram` BEFORE INSERT ON `produkty` FOR EACH ROW BEGIN
IF((SELECT ilosc_sztuk FROM ram WHERE id_RAM = new.id_RAM) < 1) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Brak kości RAM';
ELSE
    UPDATE ram
    SET ram.ilosc_sztuk = (ram.ilosc_sztuk - 1)
    WHERE id_RAM = new.id_RAM;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ram`
--

CREATE TABLE `ram` (
  `id_RAM` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `rodzaj_pamieci` varchar(15) NOT NULL,
  `pojemnosc` int(11) NOT NULL,
  `taktowanie` int(11) NOT NULL,
  `opoznienie` int(11) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `ram`
--

INSERT INTO `ram` (`id_RAM`, `firma`, `model`, `rodzaj_pamieci`, `pojemnosc`, `taktowanie`, `opoznienie`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'GOODRAM ', 'IRDM X Black', 'DDR4', 4, 3000, 16, 88, 13, 'ram/GoodRam IRDM X Black.jpg'),
(2, 'PNY ', 'Desktop Memory', 'DDR4', 8, 2666, 19, 139, 227, 'ram/PNY Desktop Memory.jpg'),
(3, 'HyperX', 'Fury Black', 'DDR3', 16, 1600, 10, 355, 65, 'ram/HyperX Fury Black.jpg'),
(4, 'G.SKILL', 'RipjawsX', 'DDR3', 8, 1600, 9, 229, 123, 'ram/G.Skill RipjawsX.jpg'),
(5, 'HyperX', 'Predator RGB', 'DDR4', 16, 3200, 16, 479, 36, 'ram/HyperX Predator RGB.png'),
(6, 'HyperX ', 'Fury White', 'DDR3', 4, 1600, 10, 164, 50, 'ram/HyperX Fury White.jpg'),
(7, 'G.SKILL', 'Trident Z RGB LED', 'DDR4', 16, 3000, 16, 549, 57, 'ram/G.Skill Trident Z RGB LED.png'),
(8, 'Crucial ', 'Ballistix Black', 'DDR4', 16, 3200, 16, 419, 33, 'ram/Crucial Ballistix Black.jpg'),
(9, 'Patriot ', 'Viper 4', 'DDR4', 16, 3000, 16, 419, 43, 'ram/Patriot Viper 4.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `id_produkty` int(11) NOT NULL,
  `data_zamowienia` date DEFAULT NULL,
  `cena_zamowienia` int(11) DEFAULT NULL,
  `data_realizacji` date DEFAULT NULL,
  `wyslano` tinyint(1) NOT NULL,
  `uwagi` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_klienta`, `id_produkty`, `data_zamowienia`, `cena_zamowienia`, `data_realizacji`, `wyslano`, `uwagi`) VALUES
(1, 1, 1, '2022-04-06', 21712, '2022-04-07', 1, '');

--
-- Wyzwalacze `zamowienia`
--
DELIMITER $$
CREATE TRIGGER `data_zam` BEFORE INSERT ON `zamowienia` FOR EACH ROW BEGIN
SET new.data_zamowienia = CURRENT_DATE;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ilosc_zam` AFTER INSERT ON `zamowienia` FOR EACH ROW BEGIN
UPDATE klienci
SET klienci.ilosc_zamowien = (SELECT COUNT(*) FROM zamowienia WHERE id_klienta = new.id_klienta)
WHERE id_klienta = new.id_klienta;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zasilacze`
--

CREATE TABLE `zasilacze` (
  `id_PSU` int(11) NOT NULL,
  `firma` varchar(25) NOT NULL,
  `model` varchar(25) NOT NULL,
  `moc` int(11) NOT NULL,
  `sprawnosc` int(11) NOT NULL,
  `certyfikat` varchar(25) DEFAULT NULL,
  `modularnosc` tinyint(1) NOT NULL,
  `cena` float NOT NULL,
  `ilosc_sztuk` int(11) NOT NULL,
  `img_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `zasilacze`
--

INSERT INTO `zasilacze` (`id_PSU`, `firma`, `model`, `moc`, `sprawnosc`, `certyfikat`, `modularnosc`, `cena`, `ilosc_sztuk`, `img_path`) VALUES
(1, 'SilentiumPC ', 'Elementum E2 ', 550, 88, '80 PLUS', 0, 179, 3, 'psu/SilentiumPC Elementum E2.jpg'),
(2, 'Cooler Master', 'MWE V2', 500, 85, '80 PLUS', 0, 199, 0, 'psu/Cooler Master MWE V2 500.jpg'),
(3, 'SilentiumPC', 'Vero L3', 600, 80, 'Bronze', 0, 239, 112, 'psu/SilentiumPC Vero L3.png'),
(4, 'Corsair', 'CV', 550, 80, 'Bronze', 0, 229, 0, 'psu/Corsair CV550.png'),
(5, 'iBOX ', 'AURORA', 500, 80, NULL, 0, 118, 3, 'psu/iBox AURORA.jpg'),
(6, 'ASUS', 'ROG Thor', 850, 92, '80 PLUS Platinum', 1, 1169, 39, 'psu/Asus ROG Thor 850w.jpg'),
(7, 'be quiet!', 'System Power 9', 600, 89, '80 PLUS Bronze', 0, 299, 35, 'psu/be quiet System Power 9.jpg'),
(8, 'Cooler Master', 'MWE Gold-V2', 750, 90, '80 PLUS Gold', 1, 479, 33, 'psu/Cooler Master MWE Gold-V2.jpg'),
(9, 'be quiet!', 'Straight Power 11 ', 750, 94, '80 PLUS Gold', 1, 669, 42, 'psu/be quiet Straight Power 11.jpg'),
(10, 'Corsair', 'CX750F RGB', 750, 87, '80 PLUS Bronze', 1, 429, 21, 'psu/Corsair CX750F RGB.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admini`
--
ALTER TABLE `admini`
  ADD PRIMARY KEY (`id_admina`);

--
-- Indeksy dla tabeli `dyski`
--
ALTER TABLE `dyski`
  ADD PRIMARY KEY (`id_dysk`);

--
-- Indeksy dla tabeli `karty_graficzne`
--
ALTER TABLE `karty_graficzne`
  ADD PRIMARY KEY (`id_GPU`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `obudowy`
--
ALTER TABLE `obudowy`
  ADD PRIMARY KEY (`id_obudowa`);

--
-- Indeksy dla tabeli `plyty_glowne`
--
ALTER TABLE `plyty_glowne`
  ADD PRIMARY KEY (`id_MOBO`);

--
-- Indeksy dla tabeli `procesory`
--
ALTER TABLE `procesory`
  ADD PRIMARY KEY (`id_CPU`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produkty`),
  ADD KEY `id_CPU` (`id_CPU`),
  ADD KEY `id_GPU` (`id_GPU`,`id_RAM`,`id_dysk1`,`id_dysk2`,`id_MOBO`,`id_PSU`,`id_obudowa`),
  ADD KEY `id_obudowa` (`id_obudowa`),
  ADD KEY `id_PSU` (`id_PSU`),
  ADD KEY `id_RAM` (`id_RAM`),
  ADD KEY `id_dysk1` (`id_dysk1`),
  ADD KEY `id_dysk2` (`id_dysk2`),
  ADD KEY `id_MOBO` (`id_MOBO`);

--
-- Indeksy dla tabeli `ram`
--
ALTER TABLE `ram`
  ADD PRIMARY KEY (`id_RAM`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`,`id_produkty`),
  ADD KEY `id_produkty` (`id_produkty`);

--
-- Indeksy dla tabeli `zasilacze`
--
ALTER TABLE `zasilacze`
  ADD PRIMARY KEY (`id_PSU`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `admini`
--
ALTER TABLE `admini`
  MODIFY `id_admina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `dyski`
--
ALTER TABLE `dyski`
  MODIFY `id_dysk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `karty_graficzne`
--
ALTER TABLE `karty_graficzne`
  MODIFY `id_GPU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `obudowy`
--
ALTER TABLE `obudowy`
  MODIFY `id_obudowa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `plyty_glowne`
--
ALTER TABLE `plyty_glowne`
  MODIFY `id_MOBO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `procesory`
--
ALTER TABLE `procesory`
  MODIFY `id_CPU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produkty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `ram`
--
ALTER TABLE `ram`
  MODIFY `id_RAM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `zasilacze`
--
ALTER TABLE `zasilacze`
  MODIFY `id_PSU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`id_obudowa`) REFERENCES `obudowy` (`id_obudowa`),
  ADD CONSTRAINT `produkty_ibfk_2` FOREIGN KEY (`id_PSU`) REFERENCES `zasilacze` (`id_PSU`),
  ADD CONSTRAINT `produkty_ibfk_3` FOREIGN KEY (`id_CPU`) REFERENCES `procesory` (`id_CPU`),
  ADD CONSTRAINT `produkty_ibfk_4` FOREIGN KEY (`id_RAM`) REFERENCES `ram` (`id_RAM`),
  ADD CONSTRAINT `produkty_ibfk_5` FOREIGN KEY (`id_dysk1`) REFERENCES `dyski` (`id_dysk`),
  ADD CONSTRAINT `produkty_ibfk_6` FOREIGN KEY (`id_dysk2`) REFERENCES `dyski` (`id_dysk`),
  ADD CONSTRAINT `produkty_ibfk_7` FOREIGN KEY (`id_MOBO`) REFERENCES `plyty_glowne` (`id_MOBO`),
  ADD CONSTRAINT `produkty_ibfk_8` FOREIGN KEY (`id_GPU`) REFERENCES `karty_graficzne` (`id_GPU`);

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_produkty`) REFERENCES `produkty` (`id_produkty`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
