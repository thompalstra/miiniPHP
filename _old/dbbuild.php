<?php
// $initial = str_replace( '{$prefix}', $prefix, $initial );

// var_dump( DB_USER ); die;
//
// echo '<pre>';
// var_dump($initial); die;
//
// create_table( "{$prefix}_post", array(
//   'id' => 'AI PK',
//   'post_type_id' => 'INT(11)',
//   'title' => 'VARCHAR(255)',
//   'description' => 'TEXT',
//   'is_published' => 'TINYINT(1)'        // indicates if the post type can be shown
// ) );
//
// create_table( "{$prefix}_post_type", array(
//   'id' => 'AI PK',
//   'title' => 'VARCHAR(255)',
//   'label_singular' => 'VARCHAR(255)',
//   'label_plural' => 'VARCHAR(255)',
//   'is_system' => 'TINYINT(1)'             // indicates if the post type can be deleted
// ) );
//
// create_table( "{$prefix}_post_type_field", array(
//   'id' => 'AI PK',
//   'post_type_id' => 'INT(11)',
//   'slug' => 'VARCHAR(255)',
//   'label_singular' => 'VARCHAR(255)',
//   'label_plural' => 'VARCHAR(255)',
//   'field_type' => 'VARCHAR(255)',
//   'field_value' => 'TEXT'
// ) );
//
// create_table( "{$prefix}_category", array(
//   'id' => 'AI PK',
//   'title' => 'VARCHAR(255)',
//   'slug' => 'VARCHAR(255)',
// ) );
//
// create_table( "{$prefix}_post_category", array(
//   'id' => 'AI PK',
//   "post_id" => 'INT(11)',
//   "category_id" => 'INT(11)'
// ) );
//
// project_post
// COLUMN                VALUE
// id                    1
// post_type_id          1
// title                 home
// description           <h2>Welcome to the home page</h2>
// is_published          1
//
// project_post_type
// COLUMN                VALUE
// id                    1
// title                 Pagina posttype
// label_singular        Pagina
// label_plural          Paginas
// is_system             1
//
// project_post_field
// COLUMN                VALUE
// id                    1
// post_id               1
// post_type_id          1
// field_name            "meta_description"
// field_value           "<meta type='description' content='Dit is een omschrijving'>"
//
// project_post_type_field
// COLUMN                VALUE
// id                    1
// post_type_id          1
// slug                  "meta_description"
// label_singular        "Meta description"
// label_plural          "Meta descriptions"
// field_type           "text"
// default_value         "<meta>"
//
// $post = [
//   'id' => 1,
//   'post_type_id' => 1,
//   'title' => 'home',
//   'description' => '<h2>Welcome to the home page</h2>',
//   'is_published' => 1
// ];
// /*
// SELECT * FROM {$prefix}_post_field
// WHERE field_name = "$tag" AND post_id = $post->id AND post_type_id = $post->post_type_id
// */
// get_post_field( $post, 'meta_description' ) = "<meta type='description' content='Dit is een omschrijving'>"
// /*
// SELECT * FROM {$prefix}_post
// LEFT JOIN project_post_field ppf ppf.post_id = $post->id
// WHERE {$prefix}_post.id = $post->id AND {$prefix}_post.post_type_id = $post->post_type_id
// */
// get_post_fields( get_post_type( $post ) ) = [
//   'meta_description' => "<meta type='description' content='Dit is een omschrijving'>"
// ];
//




?>
