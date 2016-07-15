<?php 
require (__DIR__.'/../bootstrap.php');

$data = getUrtServerStatus($host, $port, $connectionTimeout);
$maxClients = $data['info']['sv_maxclients'];
$totalPlayers = count($data['players']);
$mapName = $data['info']['mapname'];
?>

<meta charset="utf-8">
<meta http-equiv="refresh" content="30">
<title> <?php echo "$totalPlayers/$maxClients - $mapName"; ?></title>

<p>Currently playing: <?php echo $totalPlayers; ?>/<?php echo $maxClients; ?></p>
<p>Map Name: <?php echo $data['info']['mapname']?></p>


<?php if(count($data['players'])): ?>
<table>
	<tr>
		<th>name</th>
		<th>score</th>
		<th>ping</th>
	</tr>

<?php foreach($data['players'] as $player):?>
	<tr>
		<td><?php echo $player['name']?></td>
		<td><?php echo $player['score']?></td>
		<td><?php echo $player['ping']?></td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=166197950460960";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="http://nadimtuhin.com/urt" data-numposts="5"></div>