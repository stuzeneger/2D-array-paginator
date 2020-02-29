<?php
@session_start();
require ('paginator.php');

/**
 * This is an HTML example for 2D array paginator class
 *
 */
 

//init params
if(isset($_GET['page'])) $_SESSION['page']=intval(@$_GET['page']);
if(isset($_GET['rows_in_page'])) {$_SESSION['rows_in_page']=intval(@$_GET['rows_in_page']); $_SESSION['page']=0;}

if(isset($_GET['sorting'])) $_SESSION['sorting']=intval(@$_GET['sorting']);
if(isset($_GET['column'])) $_SESSION['column']=intval(@$_GET['column']); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>2D arrays pagination example</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
span {padding: 5px;}
td, th {border:1px solid black}
</style>
</head>
<body>
<?php
// test array data
$array = array(['p1' ,31, 2],['p2', 2, 1],['p3' ,23,6],['p4' ,34, 2],['p5' , 28, 2],['p6', 6, 8],['p7' ,6,2],['p8' ,6, 16],['p9' ,41, 11],['p10' , 46, 13], ['p11', 47, 4],['p12' , 18, 5], ['p13' ,44, 9]);

$paginator=new Paginator($array, intval(@$_SESSION['rows_in_page'])); // create pagination class with data array and rows per page parameter

// get data from paginator class
$totalRows=$paginator->getTotalRows();
$sortingModes=$paginator->getSortingModes();
$pagesCount=$paginator->getPagesCount();
$columnsCount=$paginator->getColumnsCount();

// page components
sortingColumnSwitcher($columnsCount, intval(@$_SESSION['column']));
sortingModeSwitcher($sortingModes, $_SESSION['sorting']);
?>
<div>
<?php
rowsInPageSwitcher($totalRows, intval(@$_SESSION['rows_in_page']));
pagesSwitcher($pagesCount, intval(@$_SESSION['page']), intval(@$_SESSION['rows_in_page']));
?>
</div>
<?php

// fetch pagination table from array
$data=$paginator->fetch2DArrayPaginationData(intval(@$_SESSION['page']), intval(@$_SESSION['column']), intval(@$_SESSION['sorting']));

// show table
table($data, $columnsCount);


function table(array $data, int $columnsCount)
{
?><table>
<tr>
<?php
    for ($i = 0;$i < $columnsCount;$i++)
    {
?><th>Column <?php echo $i; ?></th><?php
    }
?>
</tr>
<?php
    foreach ($data as $row)
    {
?>
<tr><td>
<?php echo implode('</td><td>', $row) ;?>
</td></tr>
<?php
}
?>
</table>
<?php
}


function pagesSwitcher(int $pagesCount, int $selectedPage, int $rowsInPage) {
if($rowsInPage > 0)
{
?>
<strong>Page of table:</strong>
<?php
   for($i=0;$i<$pagesCount;$i++) 
	{
	$pageCaption='<span>Page '. $i . '</span>';
	
	if($selectedPage==$i) echo $pageCaption;
	  else
	echo '<a href="index.php?page='.$i.'">'.$pageCaption.'</a>';
	}  
}
}

function sortingModeSwitcher($sortingModes, $sorting = 0)
{
?>
<strong>Sorting mode: </strong>
<?php
    foreach ($sortingModes as $sortingMode)
    {
        $caption = '<span>' . $sortingMode['caption'] . '</span>';

        if ($sorting == $sortingMode['mode']) echo  $caption;
        else echo '<a href="index.php?sorting=' . $sortingMode['mode'] . '">' . $caption . '</a>';
    }
}

function sortingColumnSwitcher($columnsCount, $sortColumn)
{
?>
<strong>Sorting column: </strong>
<?php
    for ($i = 0;$i < $columnsCount;$i++)
    {
        $caption = '<span>Column ' . $i . '</span>';
        if ($i == $sortColumn) echo $caption;
        else echo '<a href="index.php?column=' . $i . '">' . $caption . '</a>';
    }
}

function rowsInPageSwitcher($totalRows, $rowsInPage)
{
?>
<strong>Rows in page: </strong>
<select name="itemsInPage" onchange="javascript:location.href = 'index.php?rows_in_page='+this.value;">
<?php
for($i=0; $i < $totalRows; $i++)
{
echo '<option';if($i==$rowsInPage) echo ' selected';echo '>' . $i . '</option>';
}
?>
</select>
<?php
}
?>
</body>
</html>