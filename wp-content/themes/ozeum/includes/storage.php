<?php
/**
 * Theme storage manipulations
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'ozeum_storage_get' ) ) {
	function ozeum_storage_get( $var_name, $default = '' ) {
		global $OZEUM_STORAGE;
		return isset( $OZEUM_STORAGE[ $var_name ] ) ? $OZEUM_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'ozeum_storage_set' ) ) {
	function ozeum_storage_set( $var_name, $value ) {
		global $OZEUM_STORAGE;
		$OZEUM_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'ozeum_storage_empty' ) ) {
	function ozeum_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $OZEUM_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $OZEUM_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $OZEUM_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $OZEUM_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'ozeum_storage_isset' ) ) {
	function ozeum_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $OZEUM_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $OZEUM_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $OZEUM_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $OZEUM_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'ozeum_storage_inc' ) ) {
	function ozeum_storage_inc( $var_name, $value = 1 ) {
		global $OZEUM_STORAGE;
		if ( empty( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = 0;
		}
		$OZEUM_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'ozeum_storage_concat' ) ) {
	function ozeum_storage_concat( $var_name, $value ) {
		global $OZEUM_STORAGE;
		if ( empty( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = '';
		}
		$OZEUM_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'ozeum_storage_get_array' ) ) {
	function ozeum_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $OZEUM_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $OZEUM_STORAGE[ $var_name ][ $key ] ) ? $OZEUM_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $OZEUM_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $OZEUM_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'ozeum_storage_set_array' ) ) {
	function ozeum_storage_set_array( $var_name, $key, $value ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$OZEUM_STORAGE[ $var_name ][] = $value;
		} else {
			$OZEUM_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'ozeum_storage_set_array2' ) ) {
	function ozeum_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $OZEUM_STORAGE[ $var_name ][ $key ] ) ) {
			$OZEUM_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$OZEUM_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$OZEUM_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'ozeum_storage_merge_array' ) ) {
	function ozeum_storage_merge_array( $var_name, $key, $value ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$OZEUM_STORAGE[ $var_name ] = array_merge( $OZEUM_STORAGE[ $var_name ], $value );
		} else {
			$OZEUM_STORAGE[ $var_name ][ $key ] = array_merge( $OZEUM_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'ozeum_storage_set_array_after' ) ) {
	function ozeum_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			ozeum_array_insert_after( $OZEUM_STORAGE[ $var_name ], $after, $key );
		} else {
			ozeum_array_insert_after( $OZEUM_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'ozeum_storage_set_array_before' ) ) {
	function ozeum_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			ozeum_array_insert_before( $OZEUM_STORAGE[ $var_name ], $before, $key );
		} else {
			ozeum_array_insert_before( $OZEUM_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'ozeum_storage_push_array' ) ) {
	function ozeum_storage_push_array( $var_name, $key, $value ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $OZEUM_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $OZEUM_STORAGE[ $var_name ][ $key ] ) ) {
				$OZEUM_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $OZEUM_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'ozeum_storage_pop_array' ) ) {
	function ozeum_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $OZEUM_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $OZEUM_STORAGE[ $var_name ] ) && is_array( $OZEUM_STORAGE[ $var_name ] ) && count( $OZEUM_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $OZEUM_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $OZEUM_STORAGE[ $var_name ][ $key ] ) && is_array( $OZEUM_STORAGE[ $var_name ][ $key ] ) && count( $OZEUM_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $OZEUM_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'ozeum_storage_inc_array' ) ) {
	function ozeum_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( empty( $OZEUM_STORAGE[ $var_name ][ $key ] ) ) {
			$OZEUM_STORAGE[ $var_name ][ $key ] = 0;
		}
		$OZEUM_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'ozeum_storage_concat_array' ) ) {
	function ozeum_storage_concat_array( $var_name, $key, $value ) {
		global $OZEUM_STORAGE;
		if ( ! isset( $OZEUM_STORAGE[ $var_name ] ) ) {
			$OZEUM_STORAGE[ $var_name ] = array();
		}
		if ( empty( $OZEUM_STORAGE[ $var_name ][ $key ] ) ) {
			$OZEUM_STORAGE[ $var_name ][ $key ] = '';
		}
		$OZEUM_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'ozeum_storage_call_obj_method' ) ) {
	function ozeum_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $OZEUM_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $OZEUM_STORAGE[ $var_name ] ) ? $OZEUM_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $OZEUM_STORAGE[ $var_name ] ) ? $OZEUM_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'ozeum_storage_get_obj_property' ) ) {
	function ozeum_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $OZEUM_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $OZEUM_STORAGE[ $var_name ]->$prop ) ? $OZEUM_STORAGE[ $var_name ]->$prop : $default;
	}
}
