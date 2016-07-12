-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2016 at 08:49 
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--

CREATE TABLE IF NOT EXISTS `t_category` (
`f_category_id` int(11) NOT NULL,
  `f_category_name` varchar(50) DEFAULT NULL,
  `f_category_parent` int(11) NOT NULL,
  `f_category_active` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_category`
--

INSERT INTO `t_category` (`f_category_id`, `f_category_name`, `f_category_parent`, `f_category_active`) VALUES
(1, 'Pemrograman', 1, 1),
(2, 'Database', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_module`
--

CREATE TABLE IF NOT EXISTS `t_module` (
`f_module_id` int(11) NOT NULL,
  `f_module_class` varchar(100) DEFAULT NULL,
  `f_module_name` varchar(150) DEFAULT NULL,
  `f_module_desc` text,
  `f_module_icon` varchar(50) DEFAULT NULL,
  `f_module_level` int(11) NOT NULL,
  `f_module_parent` int(11) DEFAULT NULL,
  `f_module_urut` int(11) NOT NULL COMMENT 'urutan',
  `f_module_active` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `t_module`
--

INSERT INTO `t_module` (`f_module_id`, `f_module_class`, `f_module_name`, `f_module_desc`, `f_module_icon`, `f_module_level`, `f_module_parent`, `f_module_urut`, `f_module_active`) VALUES
(1, '', 'Setting Webadmin', 'Setting Webadmin', 'fa fa-sliders', 0, 0, 0, 1),
(2, 'module', 'Module', 'Level 1', 'fa fa-circle-o', 1, 1, 0, 1),
(3, 'role_module', 'Role Module', 'Role Access Module', 'fa fa-circle-o', 1, 1, 2, 1),
(4, 'user', 'User', 'List User', 'fa fa-circle-o', 1, 1, 3, 1),
(5, 'webadmin/category', 'Category', 'Category', 'fa fa-circle-o', 1, 6, 2, 1),
(6, '', 'Posting', 'Posting', 'fa fa-file-text-o', 0, 0, 1, 1),
(7, 'webadmin/posting', 'List Posting', 'List Posting', 'fa fa-circle-o', 1, 6, 1, 1),
(8, 'webadmin/tag', 'Tag', 'Tag', 'fa fa-circle-o', 1, 6, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_posting`
--

CREATE TABLE IF NOT EXISTS `t_posting` (
`f_posting_id` int(11) NOT NULL,
  `f_posting_name` varchar(50) DEFAULT NULL,
  `f_posting_slug` varchar(100) DEFAULT NULL,
  `f_category_id` int(11) DEFAULT NULL,
  `f_posting_text` text,
  `f_posting_tag` varchar(200) DEFAULT NULL,
  `f_posting_image` varchar(150) DEFAULT NULL,
  `f_posting_read` int(11) NOT NULL,
  `f_posting_date` date NOT NULL,
  `f_posting_time` time NOT NULL,
  `f_posting_active` int(11) NOT NULL,
  `f_create_on` datetime DEFAULT NULL,
  `f_create_by` int(11) DEFAULT NULL,
  `f_update_date` datetime DEFAULT NULL,
  `f_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_posting`
--

INSERT INTO `t_posting` (`f_posting_id`, `f_posting_name`, `f_posting_slug`, `f_category_id`, `f_posting_text`, `f_posting_tag`, `f_posting_image`, `f_posting_read`, `f_posting_date`, `f_posting_time`, `f_posting_active`, `f_create_on`, `f_create_by`, `f_update_date`, `f_update_by`) VALUES
(1, 'Trigger MySQL Update Stock', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1),
(2, 'Trigger MySQL Update Stock 2', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1),
(3, 'Trigger MySQL Update Stock 3', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1),
(4, 'Trigger MySQL Update Stock 4', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1),
(5, 'Trigger MySQL Update Stock 5', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1),
(6, 'Trigger MySQL Update Stock 6', 'trigger-mysql-update-stock', 2, '<p>sesuia dengan judul, saya akan kasih contoh untuk mengurangi atau menambah stock. kasus kalo ini saya punya sebuah Gudang dimana ada pencatatan stok, pencatatan barang baik masuk maupun keluar. Nah kalo barang keluar maka stok gudang berkurang betul ? sebaliknya kalo barang masuk maka stok gudang bertambah betul lagi tidak ? Ok pertama2 kita siapkan dulu tabel untuk pencatatan stok ,masuk dan keluar sebagai berikut :</p>\r\n\r\n<pre>\r\n<code class="language-sql">create table stok(\r\n stok_id int primary key auto_increment,\r\n stok_nama varchar(5),\r\n stok_jumlah int\r\n);\r\n\r\ncreate table masuk(\r\n masuk_id int primary key auto_increment,\r\n stok_id int,\r\n masuk_jumlah int\r\n);\r\n\r\ncreate table keluar(\r\n keluar_id int primary key auto_increment,\r\n stok_id int,\r\n keluar_jumlah int\r\n);</code></pre>\r\n\r\n<p>Contoh pertama<br>\r\ndi Gudang Stok A = 10, pada hari ini A akan dikeluarkan 7 maka rumusnya adalah A = 10 - 7.maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER insert_keluar AFTER INSERT ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah-new.keluar_jumlah where stok_id=new.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>kalo dibaca begini : buat trigger dengan nama insert_keluar setelah insert pada tabel keluar untuk setiap barisnya mulai update dan berakhir.</p>\r\n\r\n<p>sekaran coba kita catat/insert pada tabel keluar si A = 7</p>\r\n\r\n<pre>\r\n<code class="language-sql">INSERT INTO keluar (keluar_id,stok_id,keluar_jumlah) VALUES (1,1,7);</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan berkurang menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah bagaimana dengan Stok A yang masuk ke gudang ? yah namanya barang masuk ke Gudang maka stok bertambah donk, gimana caranya ? tinggal copy paste trigger insert_keluar yang harus diganti : nama trigger,tabel masuk, updatenya adalah tambah</p>\r\n\r\n<p>Contoh Kedua<br>\r\nTernyata oh ternyata ada kesalahan pada pencatatan keluar. Jumlah si A yang keluar seharunya 4 bukan 7 !! nah loh .. pegimana nie ? Tenang logikanya harus tau selisih dari kesalahan input dan di masukan kembali ke stok A jadi rumusnya<br>\r\nselisih = 7 - 4 = 3<br>\r\nStok A = 3 + 3 = 6 atau 10 - 4 = 6</p>\r\n\r\n<p>Jadi stok A pada gudang haruslah 6, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER update_keluar AFTER UPDATE ON keluar\r\nFOR EACH ROW BEGIN\r\ndeclare a int;\r\nset a = old.keluar_jumlah - new.keluar_jumlah;\r\nupdate stok set stok_jumlah=stok_jumlah+a where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita ubah/update pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">UPDATE keluar SET keluar_jumlah=4 WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A akan bertambah menjadi 3</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Contoh Ketiga<br>\r\ndan akhirnya si A tidak jadi keluar. Jumlah si A harus kembali kesemula yaitu 10, maka trigger pada mysql</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELIMITER //\r\nCREATE TRIGGER delete_keluar AFTER DELETE ON keluar\r\nFOR EACH ROW BEGIN\r\nupdate stok set stok_jumlah=stok_jumlah+old.keluar_jumlah where stok_id=old.stok_id;\r\nEND\r\n//\r\nDELIMITER ;</code></pre>\r\n\r\n<p>sekarang coba kita hapus/delete pada tabel keluar si A = 4</p>\r\n\r\n<pre>\r\n<code class="language-sql">DELETE FROM keluar WHERE keluar.keluar_id = 1;</code></pre>\r\n\r\n<p>Maka pada Gudang untuk stok A kembali semula</p>\r\n\r\n<pre>\r\n<code class="language-sql">SELECT * FROM stok;</code></pre>\r\n\r\n<p>Nah itu saja pengalaman saya dapat. walaupun sedikit mudah-mudahan bermanfaat.</p>\r\n\r\n<p>Penjelasan OLD dan NEW pada trigger:<br>\r\nOLD : berisi data sebelum perubahan<br>\r\nNEW : berisi data sesudah perubahan</p>\r\n', 'MySQL', 'http://localhost/assets/filemanager/../uploads/databaseTrigger.jpg', 0, '2016-07-08', '06:48:20', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE IF NOT EXISTS `t_role` (
`f_role_id` int(9) NOT NULL COMMENT 'Role ID',
  `f_role_code` varchar(15) NOT NULL DEFAULT ' ' COMMENT 'Role Code',
  `f_role_name` varchar(150) NOT NULL DEFAULT ' ' COMMENT 'Role Name',
  `f_role_desc` text NOT NULL COMMENT 'role Description',
  `f_role_active` int(1) NOT NULL DEFAULT '1' COMMENT 'Role Active Status'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`f_role_id`, `f_role_code`, `f_role_name`, `f_role_desc`, `f_role_active`) VALUES
(1, 'superadmin', 'System Administrator', 'System Administrator Role', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_role_module`
--

CREATE TABLE IF NOT EXISTS `t_role_module` (
  `f_role_id` int(9) NOT NULL DEFAULT '0' COMMENT 'Role ID from table Role',
  `f_module_id` int(9) NOT NULL DEFAULT '0' COMMENT 'Module ID from table Module',
  `f_add_button_status` int(10) NOT NULL,
  `f_edit_button_status` int(10) NOT NULL,
  `f_delete_button_status` int(10) NOT NULL,
  `f_export_button_status` int(10) NOT NULL,
  `f_import_button_status` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

--
-- Dumping data for table `t_role_module`
--

INSERT INTO `t_role_module` (`f_role_id`, `f_module_id`, `f_add_button_status`, `f_edit_button_status`, `f_delete_button_status`, `f_export_button_status`, `f_import_button_status`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(1, 2, 1, 1, 1, 1, 1),
(1, 3, 1, 1, 1, 1, 1),
(1, 4, 1, 1, 1, 1, 1),
(1, 5, 1, 1, 1, 1, 1),
(1, 6, 1, 1, 1, 1, 1),
(1, 7, 1, 1, 1, 1, 1),
(1, 8, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_tag`
--

CREATE TABLE IF NOT EXISTS `t_tag` (
`f_tag_id` int(11) NOT NULL,
  `f_tag_name` varchar(50) DEFAULT NULL,
  `f_tag_active` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_tag`
--

INSERT INTO `t_tag` (`f_tag_id`, `f_tag_name`, `f_tag_active`) VALUES
(1, 'PHP', 1),
(2, 'Framework Codeigniter', 1),
(3, 'MySQL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
`f_user_id` int(11) NOT NULL,
  `f_user_email` varchar(50) DEFAULT NULL COMMENT 'Login',
  `f_user_password` varchar(50) DEFAULT NULL,
  `f_user_name` varchar(50) DEFAULT NULL,
  `f_user_role` int(11) DEFAULT NULL,
  `f_user_active` int(11) DEFAULT NULL,
  `f_user_create_on` datetime DEFAULT NULL,
  `f_user_create_by` int(11) DEFAULT NULL,
  `f_user_update_on` datetime DEFAULT NULL,
  `f_user_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`f_user_id`, `f_user_email`, `f_user_password`, `f_user_name`, `f_user_role`, `f_user_active`, `f_user_create_on`, `f_user_create_by`, `f_user_update_on`, `f_user_update_by`) VALUES
(1, 'mustopaamin@ymail.com', 'fefb82fe67f8596ae3d269c7039caa55c4b5c8e6', 'Mustopa', 1, 1, '2016-07-04 00:00:00', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_category`
--
ALTER TABLE `t_category`
 ADD PRIMARY KEY (`f_category_id`);

--
-- Indexes for table `t_module`
--
ALTER TABLE `t_module`
 ADD PRIMARY KEY (`f_module_id`);

--
-- Indexes for table `t_posting`
--
ALTER TABLE `t_posting`
 ADD PRIMARY KEY (`f_posting_id`);

--
-- Indexes for table `t_role`
--
ALTER TABLE `t_role`
 ADD PRIMARY KEY (`f_role_id`);

--
-- Indexes for table `t_role_module`
--
ALTER TABLE `t_role_module`
 ADD PRIMARY KEY (`f_role_id`,`f_module_id`);

--
-- Indexes for table `t_tag`
--
ALTER TABLE `t_tag`
 ADD PRIMARY KEY (`f_tag_id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
 ADD PRIMARY KEY (`f_user_id`), ADD UNIQUE KEY `f_user_email` (`f_user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_category`
--
ALTER TABLE `t_category`
MODIFY `f_category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_module`
--
ALTER TABLE `t_module`
MODIFY `f_module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `t_posting`
--
ALTER TABLE `t_posting`
MODIFY `f_posting_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
MODIFY `f_role_id` int(9) NOT NULL AUTO_INCREMENT COMMENT 'Role ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_tag`
--
ALTER TABLE `t_tag`
MODIFY `f_tag_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
MODIFY `f_user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
