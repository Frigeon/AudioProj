<?php
include '../model/db.php';

if(!isset($_POST['fileName']))
{
	echo json_encode(array('errors'=>'File Name was not set'));
	return;
}

$con = new DB();
$con->connect();

$fileID = $con->getFileID($_POST['fileName']);

$data = $con->getDataByFileID($fileID);

$rows = '<table  class="DataRow"><tr ><th>eventStart</th><th>eventEnd</th><th>relevance</th><th>accousticReleveance</th><th>contextRelevance</th>'
			.'<th>seasonRelevance</th><th>timeRelevance</th><th>habitatRelevance</th><th>regionRelevance</th></tr>';

foreach($data as $val)
{
	$rows .= '<tr >'
					.'<td>'.$val['eventStart'].'</td>'
					.'<td>'.$val['eventEnd'].'</td>'
					.'<td>'.number_format ($val['relevance'], 2).'</td>' 
					.'<td>'.number_format ($val['accousticReleveance'], 2).'</td>'
					.'<td>'.number_format ($val['contextRelevance'], 2).'</td>'
					.'<td>'.number_format ($val['seasonRelevance'], 2).'</td>'
					.'<td>'.number_format ($val['timeRelevance'], 2).'</td>'
					.'<td>'.number_format ($val['habitatRelevance'], 2).'</td>'
					.'<td>'.number_format ($val['regionRelevance'], 2).'</td>'
			.'</tr>';
}
$rows .= '</table>';
echo json_encode(array('fileId'=>$fileID, 'data'=>$rows));
return;