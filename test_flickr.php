<?php
require_once('class.flickr.php');
$flickr = new flickr('YOUR FLICKR API KEY', 'YOUR FLICKR SECRET KEY', 'json');
$results = $flickr->searchPhotos('pikachu');
foreach($results as $r){
	$src =  "http://farm" . $r['farm'] . ".static.flickr.com/" . $r['server'] . '/' . $r['id'] . '_' . $r['secret'] . '_m.jpg';
?>
	<img src="<?php echo $src; ?>" alt="">
<?php
}
?>