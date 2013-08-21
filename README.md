tf2Stats
========

PHP класс для получения статистики сервера Team Fortress 2

Пример использования класса.

	<?
	include 'tf2Stats.class.php';

	$stat = new tfStat($adr,$port);
	$st=$stat->get();
	echo json_encode($st)
