<?php

// Get the nav menu based on the requested menu
$menu = wp_get_nav_menu_object( "Main" );
$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

?>

<nav class="navbar  navbar-expand-lg navbar-light">
    
    <!--botón hamburger-->
    <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!--botón lupa-->
    <button class="navbar-toggler lupa-btn mr-3" type="button" data-toggle="collapse" data-target="#collapseSearch" aria-controls="collapseSearch" aria-expanded="false" aria-label="Search">
        <span class="fa fa-search" aria-hidden="true"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo01">
        <ul class="navbar-nav  mt-2 mt-lg-0 ">

<?php

$render_menu = "";          
$items_menu_tree = array();

// Formas un árbol para anidar lo elementos hijos en los padres (Solo para un nivel)
foreach($menu_items as $item){

    if( !empty($item->menu_item_parent) && $item->menu_item_parent != 0 ){
      foreach($items_menu_tree as $item_parent){
        if($item_parent["item"]->ID == $item->menu_item_parent){
          $items_menu_tree[$item_parent["item"]->menu_order]["children"][] = $item;
        }
      }
    }else{
      $items_menu_tree[$item->menu_order]["item"] = $item;
    }
}



// Generando el string del menú
foreach($items_menu_tree as $item_li){
  if( !isset($item_li["children"]) ){
    $render_menu .= '
    <li class="nav-item text-center">
      <a class="nav-link" href="'.$item_li["item"]->url.'">'.$item_li["item"]->title.'</a>
    </li>
    ';
  }else{
    $render_menu .= '
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-center" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="'.$item_li['item']->guid.'" >'.$item_li["item"]->title.'</a>
      <div  aria-labelledby="navbarDropdown"  class="dropdown-menu text-center">';
      foreach($item_li["children"] as $child){
        $render_menu .= '<a class="dropdown-item" href="'.$child->url.'">'.$child->title.'</a>';
      } 
      $render_menu .='</div>
    </li>
    ';
  }
}
  
echo $render_menu;

?>

            </ul>
        </div>                   
    </nav>
    <div class="collapse" id="collapseSearch">
        <form class="form-inline d-flex justify-content-center">
            <input class="form-control mr-sm-2" type="text" placeholder="texto para buscar...">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
