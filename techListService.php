<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Marcellus
 * Date: 10/31/15
 * Time: 1:43 PM
 * To change this template use File | Settings | File Templates.
 */

// start the session
header("Cache-control: private"); //IE 6 Fix
include_once ("dbconfig.php");

$mysqli = new mysqli($dbhost, $dbusername, $dbpass, $dbname);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$q = htmlspecialchars($_GET["q"]);


$sql = "SELECT post_title, post_date, metaurl.meta_value url, metadate.meta_value event_date FROM wp_posts posts, wp_term_relationships rels, wp_terms terms, wp_postmeta metaurl, wp_postmeta metadate WHERE posts.post_status = 'publish' AND posts.post_type = 'post' AND posts.ID = rels.object_id AND terms.slug = 'techies-list' AND rels.term_taxonomy_id = terms.term_id AND metaurl.post_id = posts.id AND metaurl.meta_key = 'event_website_url' AND metadate.post_id = posts.id AND metadate.meta_key = 'event_date'";
$sql .= " UNION ";
$sql .= "SELECT post_title, post_date, metaurl.meta_value url, metadate.meta_value event_date FROM wp_posts posts, wp_term_relationships rels, wp_terms terms, wp_postmeta metaurl, wp_postmeta metadate WHERE posts.post_status = 'publish' AND posts.post_type = 'post' AND posts.ID = rels.object_id AND terms.slug = 'techies-list' AND rels.term_taxonomy_id = terms.term_id AND metaurl.post_id = posts.id AND metaurl.meta_key = 'event_website_url' AND metadate.post_id = posts.id AND metadate.meta_key = 'tl-date' order by event_date desc LIMIT ". $q;
//SELECT post_title, metaurl.meta_value url, metadate.meta_value event_date FROM wp_posts posts, wp_term_relationships rels, wp_terms terms, wp_postmeta metaurl, wp_postmeta metadate WHERE posts.post_status = 'publish' AND posts.post_type = 'post' AND posts.ID = rels.object_id AND terms.slug = 'techies-list' AND rels.term_taxonomy_id = terms.term_id AND metaurl.post_id = posts.id AND metaurl.meta_key = 'event_website_url' AND metadate.post_id = posts.id AND metadate.meta_key = 'event_date'
//
//UNION
//
//SELECT post_title, metaurl.meta_value url, metadate.meta_value event_date FROM wp_posts posts, wp_term_relationships rels, wp_terms terms, wp_postmeta metaurl, wp_postmeta metadate WHERE posts.post_status = 'publish' AND posts.post_type = 'post' AND posts.ID = rels.object_id AND terms.slug = 'techies-list' AND rels.term_taxonomy_id = terms.term_id AND metaurl.post_id = posts.id AND metaurl.meta_key = 'event_website_url' AND metadate.post_id = posts.id AND metadate.meta_key = 'tl-date' order by event_date desc

$qTechListPosts = $mysqli->query($sql);

$rows = array();
$i=0;
while($r = mysqli_fetch_assoc($qTechListPosts)) {
    $rows[] = $r;
}

echo json_encode($rows);

?>