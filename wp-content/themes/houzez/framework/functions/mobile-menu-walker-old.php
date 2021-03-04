<?php
/**
 * Create HTML list of nav menu items.
 */
class houzez_mobile_nav_walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
	{

		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
    /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item   Menu item data object.
     * @param  int $depth     Depth of menu item. May be used for padding.
     * @param  array $args    Additional strings.
     * @return void
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes     = empty ( $item->classes ) ? array () : (array) $item->classes;

        $class_names = join(
            ' '
        ,   apply_filters(
                'nav_menu_css_class'
            ,   array_filter( $classes ), $item
            )
        );

        $dropdown_anchor_calss = '';
        $dropdown_li_class = '';
        if($args->has_children) {
        	$dropdown_li_class = "dropdown";
        	$dropdown_anchor_calss = "dropdown-toggle";
        }

        ! empty ( $class_names )
            and $class_names = ' class="nav-item '. esc_attr( $class_names.' '.$dropdown_li_class ) . '"';

        $output .= "<li $class_names>";

        $attributes  = '';

        if($depth > 0 ) {
        	$attributes .=  ' class="dropdown-item '.$dropdown_anchor_calss.'"';
        } else {
	        $attributes .=  ' class="nav-link '.$dropdown_anchor_calss.'"';
	    }

        $attributes .= $args->has_children ? ' data-toggle="dropdown" ' : '';
        
        ! empty( $item->attr_title )
            and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
        ! empty( $item->target )
            and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
        ! empty( $item->xfn )
            and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
        ! empty( $item->url )
            and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

        
        $description = ( ! empty ( $item->description ) and 0 == $depth )
            ? '<small class="nav_desc">' . esc_attr( $item->description ) . '</small>' : '';

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before
            . "<a $attributes>"
            . $args->link_before
            . $title
            . '</a> '
            . $args->link_after
            . $description
            . $args->after;

        // Since $output is called by reference we don't need to return anything.
        $output .= apply_filters(
            'walker_nav_menu_start_el'
        ,   $item_output
        ,   $item
        ,   $depth
        ,   $args
        );
    }

    function start_lvl( &$output, $depth=0, $args = array() ) {


        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'dropdown-menu'
            );
        $class_names = implode( ' ', $classes );

        // build html
        $output .= "\n" . $indent . '<ul class="' . esc_attr( $class_names ) . '">' . "\n";
    }

    function end_lvl( &$output, $depth=0, $args = array() ) {

        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";

    }
}