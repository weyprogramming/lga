<?php
/**
 * Plugin Name: Albermann Speisekarte
 * Description: Pflege der Abendkarte im WordPress-Backend. Ausgabe auf einer Seite mit dem Shortcode [abendkarte], inklusive strukturierter Daten (schema.org Menu) für Google.
 * Version:     1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License:     GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;

const AB_GERICHT = 'ab_gericht';
const AB_BEREICH = 'ab_bereich';

/*
 * Data model: each dish is a post of type "ab_gericht" (name = title, sorted by "Reihenfolge").
 * Each menu section is a term of the taxonomy "ab_bereich" with its own sort order and an
 * optional set-menu price. Dishes in a set menu leave their own price empty.
 */

add_action( 'init', 'ab_registrieren' );

function ab_registrieren() {
	register_post_type(
		AB_GERICHT,
		array(
			'labels'        => array(
				'name'               => 'Speisekarte',
				'singular_name'      => 'Gericht',
				'menu_name'          => 'Speisekarte',
				'all_items'          => 'Alle Gerichte',
				'add_new'            => 'Gericht hinzufügen',
				'add_new_item'       => 'Neues Gericht hinzufügen',
				'edit_item'          => 'Gericht bearbeiten',
				'new_item'           => 'Neues Gericht',
				'search_items'       => 'Gerichte durchsuchen',
				'not_found'          => 'Keine Gerichte gefunden',
				'not_found_in_trash' => 'Keine Gerichte im Papierkorb',
				'attributes'         => 'Reihenfolge',
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'menu_position' => 21,
			'menu_icon'     => 'dashicons-food',
			'supports'      => array( 'title', 'page-attributes' ),
		)
	);

	register_taxonomy(
		AB_BEREICH,
		AB_GERICHT,
		array(
			'labels'            => array(
				'name'          => 'Kartenbereiche',
				'singular_name' => 'Kartenbereich',
				'menu_name'     => 'Kartenbereiche',
				'all_items'     => 'Alle Kartenbereiche',
				'edit_item'     => 'Kartenbereich bearbeiten',
				'add_new_item'  => 'Neuen Kartenbereich hinzufügen',
				'search_items'  => 'Kartenbereiche durchsuchen',
				'not_found'     => 'Keine Kartenbereiche gefunden',
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
		)
	);
}

/* ---------- Dish fields (description, price, extras) ---------- */

add_action( 'add_meta_boxes', 'ab_metabox_hinzufuegen' );

function ab_metabox_hinzufuegen() {
	add_meta_box( 'ab_gericht_details', 'Angaben zum Gericht', 'ab_metabox_anzeigen', AB_GERICHT, 'normal', 'high' );
}

function ab_metabox_anzeigen( $post ) {
	wp_nonce_field( 'ab_gericht_speichern', 'ab_nonce' );
	$beschreibung = get_post_meta( $post->ID, 'ab_beschreibung', true );
	$preis        = get_post_meta( $post->ID, 'ab_preis', true );
	$zusatz       = get_post_meta( $post->ID, 'ab_zusatz', true );
	?>
	<p>
		<label for="ab_beschreibung"><strong>Beschreibung</strong></label><br>
		<input type="text" id="ab_beschreibung" name="ab_beschreibung" class="widefat" value="<?php echo esc_attr( $beschreibung ); ?>" placeholder="z. B. Rotweinjus | glasiertes Herbstgemüse | Kartoffelpüree">
	</p>
	<p>
		<label for="ab_preis"><strong>Preis in €</strong></label><br>
		<input type="text" id="ab_preis" name="ab_preis" value="<?php echo esc_attr( $preis ); ?>" placeholder="z. B. 24 oder 24,50" style="width:10em">
		<br><span class="description">Leer lassen, wenn das Gericht zu einem Menü mit Gesamtpreis gehört.</span>
	</p>
	<p>
		<label for="ab_zusatz"><strong>Zusatz (optional)</strong></label><br>
		<textarea id="ab_zusatz" name="ab_zusatz" class="widefat" rows="2" placeholder="z. B. wahlweise mit 3 Black Tiger Garnelen (+9 €)"><?php echo esc_textarea( $zusatz ); ?></textarea>
		<br><span class="description">Wird unter dem Preis angezeigt. Aufpreise im Format „mit … (+9 €)“ erkennt Google automatisch.</span>
	</p>
	<p class="description">Den <strong>Kartenbereich</strong> wählst du rechts aus, die Position innerhalb des Bereichs rechts unten im Kasten <strong>Reihenfolge</strong> (kleinere Zahl = weiter oben).</p>
	<?php
}

add_action( 'save_post_' . AB_GERICHT, 'ab_gericht_speichern' );

function ab_gericht_speichern( $post_id ) {
	if ( ! isset( $_POST['ab_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ab_nonce'] ), 'ab_gericht_speichern' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, 'ab_beschreibung', sanitize_text_field( wp_unslash( $_POST['ab_beschreibung'] ?? '' ) ) );
	update_post_meta( $post_id, 'ab_preis', ab_preis_bereinigen( wp_unslash( $_POST['ab_preis'] ?? '' ) ) );
	update_post_meta( $post_id, 'ab_zusatz', sanitize_textarea_field( wp_unslash( $_POST['ab_zusatz'] ?? '' ) ) );
}

function ab_preis_bereinigen( $preis ) {
	return preg_replace( '/[^0-9,.]/', '', (string) $preis );
}

/* ---------- Section fields (sort order, set-menu price) ---------- */

add_action( AB_BEREICH . '_add_form_fields', 'ab_bereich_felder_neu' );
add_action( AB_BEREICH . '_edit_form_fields', 'ab_bereich_felder_bearbeiten' );
add_action( 'created_' . AB_BEREICH, 'ab_bereich_speichern' );
add_action( 'edited_' . AB_BEREICH, 'ab_bereich_speichern' );

function ab_bereich_felder_neu() {
	wp_nonce_field( 'ab_bereich_speichern', 'ab_bereich_nonce' );
	?>
	<div class="form-field">
		<label for="ab_reihenfolge">Reihenfolge auf der Karte</label>
		<input type="number" id="ab_reihenfolge" name="ab_reihenfolge" value="100">
		<p>Kleinere Zahl = weiter oben.</p>
	</div>
	<div class="form-field">
		<label for="ab_menupreis">Menüpreis in € (optional)</label>
		<input type="text" id="ab_menupreis" name="ab_menupreis" value="">
		<p>Nur für Menüs mit Gesamtpreis, z. B. „Herbstmenü“. Sonst leer lassen.</p>
	</div>
	<?php
}

function ab_bereich_felder_bearbeiten( $term ) {
	wp_nonce_field( 'ab_bereich_speichern', 'ab_bereich_nonce' );
	?>
	<tr class="form-field">
		<th scope="row"><label for="ab_reihenfolge">Reihenfolge auf der Karte</label></th>
		<td>
			<input type="number" id="ab_reihenfolge" name="ab_reihenfolge" value="<?php echo esc_attr( get_term_meta( $term->term_id, 'ab_reihenfolge', true ) ); ?>">
			<p class="description">Kleinere Zahl = weiter oben.</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="ab_menupreis">Menüpreis in € (optional)</label></th>
		<td>
			<input type="text" id="ab_menupreis" name="ab_menupreis" value="<?php echo esc_attr( get_term_meta( $term->term_id, 'ab_menupreis', true ) ); ?>">
			<p class="description">Nur für Menüs mit Gesamtpreis, z. B. „Herbstmenü“. Sonst leer lassen.</p>
		</td>
	</tr>
	<?php
}

function ab_bereich_speichern( $term_id ) {
	if ( ! isset( $_POST['ab_bereich_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['ab_bereich_nonce'] ), 'ab_bereich_speichern' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	update_term_meta( $term_id, 'ab_reihenfolge', (int) ( $_POST['ab_reihenfolge'] ?? 100 ) );
	update_term_meta( $term_id, 'ab_menupreis', ab_preis_bereinigen( wp_unslash( $_POST['ab_menupreis'] ?? '' ) ) );
}

/* ---------- Admin list columns ---------- */

add_filter( 'manage_' . AB_GERICHT . '_posts_columns', 'ab_spalten' );
add_action( 'manage_' . AB_GERICHT . '_posts_custom_column', 'ab_spalte_anzeigen', 10, 2 );

function ab_spalten( $spalten ) {
	$spalten['ab_preis']       = 'Preis';
	$spalten['ab_reihenfolge'] = 'Reihenfolge';
	unset( $spalten['date'] );
	return $spalten;
}

function ab_spalte_anzeigen( $spalte, $post_id ) {
	if ( 'ab_preis' === $spalte ) {
		$preis = get_post_meta( $post_id, 'ab_preis', true );
		echo $preis ? esc_html( $preis . ' €' ) : '–';
	} elseif ( 'ab_reihenfolge' === $spalte ) {
		echo (int) get_post_field( 'menu_order', $post_id );
	}
}

/* ---------- Output: shortcode [abendkarte] ---------- */

add_shortcode( 'abendkarte', 'ab_shortcode' );

function ab_bereiche_laden() {
	$bereiche = get_terms(
		array(
			'taxonomy'   => AB_BEREICH,
			'hide_empty' => true,
		)
	);
	if ( is_wp_error( $bereiche ) ) {
		return array();
	}
	usort(
		$bereiche,
		function ( $a, $b ) {
			return (int) get_term_meta( $a->term_id, 'ab_reihenfolge', true ) <=> (int) get_term_meta( $b->term_id, 'ab_reihenfolge', true );
		}
	);

	$ergebnis = array();
	foreach ( $bereiche as $bereich ) {
		$gerichte = get_posts(
			array(
				'post_type'      => AB_GERICHT,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'title'      => 'ASC',
				),
				'tax_query'      => array(
					array(
						'taxonomy' => AB_BEREICH,
						'terms'    => $bereich->term_id,
					),
				),
			)
		);
		if ( ! $gerichte ) {
			continue;
		}
		$ergebnis[] = array(
			'name'      => $bereich->name,
			'menupreis' => get_term_meta( $bereich->term_id, 'ab_menupreis', true ),
			'gerichte'  => array_map(
				function ( $gericht ) {
					return array(
						'name'         => $gericht->post_title,
						'beschreibung' => get_post_meta( $gericht->ID, 'ab_beschreibung', true ),
						'preis'        => get_post_meta( $gericht->ID, 'ab_preis', true ),
						'zusatz'       => get_post_meta( $gericht->ID, 'ab_zusatz', true ),
					);
				},
				$gerichte
			),
		);
	}
	return $ergebnis;
}

function ab_preis_anzeige( $preis ) {
	return $preis . ' €';
}

function ab_preis_schema( $preis ) {
	return number_format( (float) str_replace( ',', '.', $preis ), 2, '.', '' );
}

function ab_angebot( $preis ) {
	return array(
		'@type'         => 'Offer',
		'price'         => ab_preis_schema( $preis ),
		'priceCurrency' => 'EUR',
	);
}

function ab_shortcode() {
	$bereiche = ab_bereiche_laden();
	if ( ! $bereiche ) {
		return '';
	}

	$html       = '<div class="ab-speisekarte">';
	$abschnitte = array();

	foreach ( $bereiche as $bereich ) {
		$html  .= '<section><h2>' . esc_html( $bereich['name'] ) . '</h2>';
		$items  = array();

		foreach ( $bereich['gerichte'] as $g ) {
			$html .= '<div class="ab-gericht"><h3>' . esc_html( $g['name'] ) . '</h3>';
			$item  = array(
				'@type' => 'MenuItem',
				'name'  => $g['name'],
			);
			if ( '' !== $g['beschreibung'] ) {
				$html               .= '<p>' . esc_html( $g['beschreibung'] ) . '</p>';
				$item['description'] = $g['beschreibung'];
			}
			if ( '' !== $g['preis'] ) {
				$html          .= '<p class="ab-preis">' . esc_html( ab_preis_anzeige( $g['preis'] ) ) . '</p>';
				$item['offers'] = ab_angebot( $g['preis'] );
			}
			if ( '' !== $g['zusatz'] ) {
				$html .= '<p>' . nl2br( esc_html( $g['zusatz'] ) ) . '</p>';
				if ( preg_match_all( '/mit (.+?) \(\+\s*(\d+(?:[,.]\d+)?)\s*€\)/u', $g['zusatz'], $treffer, PREG_SET_ORDER ) ) {
					foreach ( $treffer as $t ) {
						$item['menuAddOn'][] = array(
							'@type'  => 'MenuItem',
							'name'   => $t[1],
							'offers' => ab_angebot( $t[2] ),
						);
					}
				}
			}
			$html   .= '</div>';
			$items[] = $item;
		}

		$abschnitt = array(
			'@type'       => 'MenuSection',
			'name'        => $bereich['name'],
			'hasMenuItem' => $items,
		);
		if ( '' !== $bereich['menupreis'] ) {
			$html               .= '<p class="ab-menupreis">' . esc_html( ab_preis_anzeige( $bereich['menupreis'] ) ) . '</p>';
			$abschnitt['offers'] = ab_angebot( $bereich['menupreis'] );
		}
		$html        .= '</section>';
		$abschnitte[] = $abschnitt;
	}
	$html .= '</div>';

	$schema = array(
		'@context'       => 'https://schema.org',
		'@type'          => 'Menu',
		'@id'            => get_permalink() . '#menu',
		'name'           => get_the_title(),
		'url'            => get_permalink(),
		'inLanguage'     => 'de',
		'hasMenuSection' => $abschnitte,
	);
	$html .= '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';

	return '<style>' . ab_css() . '</style>' . $html;
}

function ab_css() {
	return '
@font-face{font-family:"Vayentha-sans";src:url("' . esc_url( content_url( 'uploads/2025/04/Vayentha-Sans.otf' ) ) . '") format("opentype");font-display:swap}
.ab-speisekarte{max-width:760px;margin:56px auto 0;text-align:center;line-height:1.55;font-family:"Source Sans Pro",sans-serif;font-size:17px;color:var(--e-global-color-text,#5C5C5C)}
.ab-speisekarte section{margin:0 0 72px}
.ab-speisekarte h2{font-family:"Vayentha-sans","Source Sans Pro",sans-serif;color:var(--e-global-color-primary,#6E0D1B);font-size:40px;font-weight:400;line-height:1.2;letter-spacing:1px;text-transform:uppercase;margin:0 0 28px}
.ab-speisekarte .ab-gericht{margin:0 0 26px}
.ab-speisekarte h3{font-family:inherit;color:inherit;font-size:18px;font-weight:400;line-height:1.55;letter-spacing:0;text-transform:none;margin:0}
.ab-speisekarte p{font-family:inherit;color:inherit;font-size:inherit;font-weight:300;line-height:inherit;margin:0}
.ab-speisekarte .ab-menupreis{margin-top:8px}
@media(max-width:767px){.ab-speisekarte h2{font-size:32px}}';
}

/* ---------- First activation: create the current menu ---------- */

register_activation_hook( __FILE__, 'ab_aktivieren' );

function ab_aktivieren() {
	ab_registrieren();

	$vorhanden = get_posts(
		array(
			'post_type'      => AB_GERICHT,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $vorhanden ) {
		return;
	}

	$daten = require __DIR__ . '/startdaten.php';
	foreach ( $daten as $b => $bereich ) {
		$term = term_exists( $bereich['name'], AB_BEREICH );
		if ( ! $term ) {
			$term = wp_insert_term( $bereich['name'], AB_BEREICH );
		}
		if ( is_wp_error( $term ) ) {
			continue;
		}
		$term_id = (int) $term['term_id'];
		update_term_meta( $term_id, 'ab_reihenfolge', ( $b + 1 ) * 10 );
		update_term_meta( $term_id, 'ab_menupreis', $bereich['menupreis'] );

		foreach ( $bereich['gerichte'] as $i => $g ) {
			$post_id = wp_insert_post(
				array(
					'post_type'   => AB_GERICHT,
					'post_status' => 'publish',
					'post_title'  => $g['name'],
					'menu_order'  => ( $i + 1 ) * 10,
					'meta_input'  => array(
						'ab_beschreibung' => $g['beschreibung'],
						'ab_preis'        => $g['preis'],
						'ab_zusatz'       => $g['zusatz'],
					),
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				wp_set_object_terms( $post_id, $term_id, AB_BEREICH );
			}
		}
	}
}
