	// ����������� � ��
    $db = mysql_connect("localhost","root","");
    mysql_select_db("phpsite",$db);
    mysql_query("SET NAMES 'utf8'",$db);
	
	/*
	$kol - ���������� ������� ��� ������
	$art - � ����� ������ ��������
	$total - ����� �������
	$page - ������� ��������
	$str_pag - ���������� ������� ��� ���������
	*/

	// ���������

	// ������� ��������
	if (isset($_GET['page'])){
		$page = $_GET['page'];
	}else $page = 1;
	
	$kol = 3;  //���������� ������� ��� ������
	$art = ($page * $kol) - $kol;
	echo $art;
	
	// ���������� ��� ���������� ������� � �������
	$res = mysql_query("SELECT COUNT(*) FROM `lessons`");
	$row = mysql_fetch_row($res);
	$total = $row[0]; // ����� �������	
	echo $total;
	
	// ���������� ������� ��� ���������
	$str_pag = ceil($total / $kol);
	echo $str_pag;
	
	// ��������� ���������
	for ($i = 1; $i <= $str_pag; $i++){
		echo "<a href=lessons.php?page=".$i."> �������� ".$i." </a>";
	}
	
	// ������ � ����� �������
	$result = mysql_query("SELECT * FROM `lessons` LIMIT $art,$kol,$db);
	$myrow = mysql_fetch_array($result);
    do{
        echo "<h2>".$myrow['title']."</h2>";
        echo "<p>".$myrow['text']."</p>";
    } while ($myrow = mysql_fetch_array($result));
	
	
	
	
	========================= ���������� ��������� ==================================
	
		 <?php
	 //���������
			if (isset($_GET['p'])){
				 $p = $_GET['p'];
			} else {
				$p = 1; // ������� ��������
			}

			$kol = 25;  //���������� ������� ��� ������
			$art = ($p * $kol) - $kol; // ����������, � ����� ������ ��� ��������

			$query = "SELECT * FROM <table> ORDER BY id DESC LIMIT {$art},{$kol}";
			$resLinks = $db->getData($query);
	 ?>
	 
	 ...
	 
	<?php
		$res = $db->getData("SELECT COUNT(*) AS countLinks FROM <table>");
		$total = $res[0]['countLinks'];
		$str_pag = ceil($total / $kol);
	?>
	<?php if ($total > $kol): ?>
		<div class="pagination">
			<?php
				$prev_link = ($_GET['p'] > 1) ? LINKS_PAGE_URL . '?p=' . ($_GET['p'] - 1) . $search_str : 'javascript:viod(0)' ;
			?>
			<a href="<?=$prev_link?>" class="fts-service-logout pagination-link"> < </a>
			<?php if ($str_pag <= 5): ?>
				<?php for ($i = 1; $i <= $str_pag; $i++): ?>
					<?php
						$pg = (isset($_GET['p'])) ? $_GET['p'] : 1;
						$active = ($pg == $i) ? 'active' : '';
					?>
						<a href="<?=LINKS_PAGE_URL?>?p=<?=$i?><?=$search_str?>" class="fts-service-logout pagination-link <?=$active?>"> <?=$i?> </a>
				<?php endfor; ?>
			<? else: ?>
				<?php $count = ($_GET['p'] < $str_pag - 2) ? $_GET['p'] : $str_pag - 4;?>
				<?php
					if (in_array($_GET['p'], [1,2]) || !isset($_GET['p'])){
						$count = 1;
					} else if ($_GET['p'] < $str_pag - 2) {
						$count = $_GET['p'] - 1;
					}
				?>
				<?php for ($i = $count; $i <= $count + 2; $i++): ?>
					<?php
						$pg = (isset($_GET['p'])) ? $_GET['p'] : 1;
						$active = ($pg == $i) ? 'active' : '';
					?>
					<a href="<?=LINKS_PAGE_URL?>?p=<?=$i?><?=$search_str?>" class="fts-service-logout pagination-link <?=$active?>"> <?=$i?> </a>
				<?php endfor; ?>
					<span>&nbsp;. . .&nbsp;</span>
					<?php for ($i = $str_pag - 1; $i <= $str_pag; $i++): ?>
						<?php
							$pg = (isset($_GET['p'])) ? $_GET['p'] : 1;
							$active = ($pg == $i) ? 'active' : '';
						?>
						<a href="<?=LINKS_PAGE_URL?>?p=<?=$i?><?=$search_str?>" class="fts-service-logout pagination-link <?=$active?>"> <?=$i?> </a>
					<?php endfor; ?>
			 <? endif; ?>
			 <?php
				$next_link = ($_GET['p'] < $str_pag) ? LINKS_PAGE_URL . '?p=' . ($_GET['p'] + 1) . $search_str : 'javascript:viod(0)' ;
			 ?>
			 <a href="<?=$next_link?>" class="fts-service-logout pagination-link"> > </a>
	</div>
<?php endif;?>