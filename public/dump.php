<?php
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect to memcache server");
echo $memcache->getVersion();

$allSlabs = $memcache->getExtendedStats('slabs');
$items = $memcache->getExtendedStats('items');
$list = [];
foreach($allSlabs as $server => $slabs) {
    foreach($slabs AS $slabId => $slabMeta) {
        $cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
        foreach($cdump AS $keys => $arrVal) {
            if (!is_array($arrVal)) continue;
            foreach($arrVal AS $k => $v) {
                array_push($list, $k);
            }
        }
    }
}
array_pop($list);
echo "Debug at ".__FILE__." ".__LINE__." ".__FUNCTION__; echo "<pre>"; print_r($list); echo "</pre>"; die;
