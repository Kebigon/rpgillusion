<?PHP
function addpost($topic) {
	global $userrow;
	$comment = $_POST['comment'];
	if ($message = '' || $message = ' ' || !$message) // Blank post
		header("Location: index.php");
	doquery("INSERT INTO {{table}} SET topic=$topic,time=NOW(),poster=$userrow[id],post='$comment'", "comments");
	header("Location: index.php?do=comments:$topic");
}
function read($topic) {
	$title = "Comments";
	$query = doquery("SELECT * FROM {{table}} WHERE id=$topic LIMIT 1", "news");
	$newsrow = mysql_fetch_assoc($query);
	$page = "<table width=\"500px\"><tr><td class=\"title\"> &nbsp;<img src=\"././images/titre_news.gif\" alt=\"Dernière news\" /></td></tr><tr><td>\n";
	$page .= "<span class=\"light\">[".prettydate($newsrow["postdate"])."]</span><br />".nl2br($newsrow["content"]);
	$page .= "</td></tr></table>\n";


	$page .= "<table width=\"95%\"><tr><td class=\"title\"><b>Ajouter un commentaire<b></td></tr>\n";
	$query = doquery("SELECT * FROM {{table}} WHERE topic=$topic ORDER BY id ASC", "comments");
	while ($com = mysql_fetch_assoc($query)) {
		$pquery = doquery("SELECT * FROM {{table}} WHERE id=".$com['poster']." LIMIT 1", "users");
		$person = mysql_fetch_assoc($pquery);
		$page .= "<tr><td><span class=\"light\">".$person['username']." -- [".prettydate($com["time"])."]</span><br />".nl2br($com["post"])."</td></tr>";
	}
	$page .= "</table>\n";
	$page .= "<form action=index.php?do=post_comment:$topic method=post><textarea name=comment></textarea><br /><input type=submit name=submit value=Poster /></form><br />";
	$page .= "<br /><a href=index.php>Retour</a>";

	display($page, $title);
}