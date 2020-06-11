<?php
add_action('admin_menu', function(){
  add_menu_page('Migrátor', 'Migrátor', 'read', 'migrator', 'migrator_fnc','',34);
});


function migrator_fnc(){ 

global $goshop_config;
global $wpdb;
global $table_prefix;
$siteurl = get_option('siteurl');
$home    = get_option('home');

//$files_parent = scandir(get_template_directory());
//$files_all = array_merge($files_child, $files_parent);
?>

<div class="wrap">
    <h1 style="margin-bottom:1em;">Migrátor</h1>

<?php


if(isset($_POST['migration_start'])){
$files_child = scandir(CHILD_DIR);
foreach($files_child as $file){
  
  $file = CHILD_DIR.'/'.$file;
  $contents = file_get_contents($file);
  $pattern = preg_quote($_POST['migrate_from'], '/');
  $pattern = "/^.*$pattern.*\$/m";
  
  if(preg_match_all($pattern, $contents, $matches)){
     
     /* prepíše súbory */
      
     $path_to_file = $file;
     $file_contents = file_get_contents($file);
     $file_contents = str_replace($_POST['migrate_from'],$_POST['migrate_to'],$file_contents);
     file_put_contents($path_to_file,$file_contents);
     echo 'Prepísal som súbor: '.$file.'<br />';
  }

}



if(isset($_POST['create_robots'])){

  
  $robotstxt = fopen(ABSPATH . "/robots.txt", "w") or die("Unable to open file!");
  $robotstxt_content = 
  'User-agent: *
  Allow: /wp-admin/admin-ajax.php
  
  Disallow: /wp-login.php';
  
  if($goshop_config['woocommerce']){
  $robotstxt_content .= '
  Disallow: /moj-ucet
  Disallow: /nakupny-kosik
  Disallow: /kontrola-objednavky
  Disallow: /moj-ucet/zabudnute-heslo';
  }
  $robotstxt_content .= 
  '
  
  Sitemap: https://' . $_SERVER[ 'HTTP_HOST' ]. '/sitemap.xml';
  
  fwrite($robotstxt, $robotstxt_content);
  fclose($robotstxt); 
  
  }
  
  $wpdb->query('UPDATE '.$table_prefix.'postmeta SET meta_value = replace(meta_value, "'.$_POST['migrate_from'].'", "'.$_POST['migrate_to'].'")');
  $wpdb->query('UPDATE '.$table_prefix.'options SET option_value = replace(option_value, "'.$_POST['migrate_from'].'", "'.$_POST['migrate_to'].'")');
  $wpdb->query('UPDATE '.$table_prefix.'posts SET post_content = replace(post_content, "'.$_POST['migrate_from'].'", "'.$_POST['migrate_to'].'")');
  $wpdb->query('UPDATE '.$table_prefix.'posts SET guid = replace(guid, "'.$_POST['migrate_from'].'", "'.$_POST['migrate_to'].'")');
      
  echo '<h3>Migrácia prebehla úspešne</h3>';

}else {

      if(isset($_POST['migration_test'])){ 
        $files_child = scandir(CHILD_DIR);
        $wp_posts = $wpdb->get_results( 'select * from '.$table_prefix.'posts where guid like "'.$_POST['migrate_from'].'%"' );
        $wp_posts_content = $wpdb->get_results( 'select * from '.$table_prefix.'posts where post_content like "'.$_POST['migrate_from'].'%"' );
        $wp_postmeta = $wpdb->get_results( 'select * from '.$table_prefix.'postmeta where meta_value like "'.$_POST['migrate_from'].'%"' );
        $wp_options = $wpdb->get_results( 'select * from '.$table_prefix.'options where option_value like "'.$_POST['migrate_from'].'%"' );
      ?>

      Našiel som <strong><?= count($wp_posts) ?></strong> záznamov v tabuľke wp_posts 
      <br>
      Našiel som <strong><?= count($wp_posts_content) ?></strong> content záznamov v tabuľke wp_posts
      <br>
      Našiel som <strong><?= count($wp_postmeta) ?></strong> záznamov v tabuľke wp_postmeta
      <br>
      Našiel som <strong><?= count($wp_options) ?></strong> záznamov v tabuľke wp_options 
      <br><br>

      <h4>Hľadám string v súboroch</h4>
      <?php
      $strings = false;
      foreach($files_child as $file){
  
        $file = CHILD_DIR.'/'.$file;
        
        $contents = file_get_contents($file);
        $pattern = preg_quote($_POST['migrate_from'], '/');
        $pattern = "/^.*$pattern.*\$/m";
        
        if(preg_match_all($pattern, $contents, $matches)){
           $strings = true;
           echo 'Našiel som string v súbore: '.$file.'<br />';
        }
      
      }
      
      if(isset($strings) and !$strings){
        echo 'V súboroch sa táto url nenachádza<br /><br />'; 
       }else{
        echo '<br /><br />';
       }
      ?>

      <?php if($wp_posts or $wp_posts_content or $wp_postmeta or $wp_options or $strings) { ?>
      <form method="post">
          Z adresy <input type="text" value="<?= $_POST[ 'migrate_from' ]; ?>" name="migrate_from" readonly> na adresu: <input name="migrate_to" type="text" value="<?= $_POST[ 'migrate_to' ]; ?>" readonly>
          <br /><br />
          <label for="robotstxt"><input type="checkbox" id="robotstxt" name="create_robots">Vytvor robots.txt</label>
          <br /><br />
          <label for="robotstxt"><input type="checkbox" id="" name="delete_woo_tables">Vymazať woocommerce tabulky</label>
          <label for="robotstxt"><input type="checkbox" id="" name="delete_mailpoet_tables">Vymazať mailpoet tabulky</label>
          <button type="submit" name="migration_start">Spustiť migráciu</button>
      </form>
      <?php }
       
       } else { ?> 

        <form method="post">
            Z adresy <input type="url" value="" name="migrate_from" required> na adresu: <input name="migrate_to" type="url" value="https://<?= $_SERVER[ 'HTTP_HOST' ]; ?>">
            <button type="submit" name="migration_test">Spustiť test migrácie</button>
        </form>

      <?php } ?>

<?php } ?>
</div>
<?php }
 