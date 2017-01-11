<?php
require_once 'IFile.php';
require_once 'CsvFile.php';
require_once 'CsvFieldsConfig.php';
require_once 'ArrayDataMerge.php';
require_once 'DB.php';
$dbConfig = require_once 'config.php';

$file = new CsvFile(
    'data/data1.csv',
    new CsvFieldsConfig(['date', 'time', 'ip_address', 'url_from', 'url_to']),
    '|'
);

$fData = $file->open()->read();


$file = new CsvFile(
    'data/data2.csv',
    new CsvFieldsConfig(['ip_address', 'browser', 'os']),
    '|'
);

$sData = $file->open()->read();

$mergedData = ArrayDataMerge::merge($fData, $sData, 'ip_address');


$db = new DB($dbConfig);


$db->insertMulti('stat', $mergedData);

$data = $db->query("
select ip_address, os, browser,
(SELECT url_from FROM stat uf where uf.ip_address = s.ip_address order by id limit 1) as first_visit_url,
(SELECT url_to FROM stat sf where sf.ip_address = s.ip_address ORDER BY ID DESC LIMIT 1) as last_visit_url,
(select count(distinct LEAST(url_from, url_to)) from stat c where c.ip_address = s.ip_address) as count,
(SELECT TIMESTAMPDIFF(SECOND, (SELECT concat(date, ' ', time) as start from stat ts where ts.ip_address = s.ip_address LIMIT 1),
(SELECT concat(date, ' ', time) as end from stat te where te.ip_address = s.ip_address ORDER BY id desc LIMIT 1))) as time from stat s group by s.ip_address
");

?>


<table border="1px black">
    <thead>
        <tr>
            <td>IP-адрес</td>
            <td>браузер</td>
            <td>ос</td>
            <td>URL с которого зашел первый раз</td>
            <td>URL на который зашел последний раз</td>
            <td>кол-во просмотренных уникальных URL-адресов</td>
            <td>общее время пребывания на сайте</td>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $k => $v): ?>
        <tr>
            <td><?php echo implode('</td><td>', $v);?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>