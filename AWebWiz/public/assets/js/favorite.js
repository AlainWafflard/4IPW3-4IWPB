
/*
 * AVERTISSEMENT
 * Cet exo est toujours sous JQuery/AJAX.
 * Il n'est pas implanté sous Vanilla JS / FETCH.
 */


/**
 * Page load
 */
$( function() {

    // URL du serveur
    const server_url = '/public/index.php';

    // évènement associé aux boutons "add product to cart"
    $('button.add_favorite').click(function() {
        const param = {
            page        : "favorite_ajax",
            action		: "add_favorite",
            art_id      : $(this).attr('for')
        };
        $.post( server_url, param, display_cart, "json" );
    });

    // évènement associé aux boutons "delete product from cart"
    $('button.del_favorite').click(function() {
        const param = {
            page        : "favorite_ajax",
            action		: "del_favorite",
            art_id      : $(this).attr('for')
        };
        $.post( server_url, param, display_cart, "json" );
    });

    // évènement associé au bouton "effacer panier"
    $('button.del_cart').click(function() {
        if(confirm( "Are you sure ?"))
        {
            const param = {
                action : "del_all_favorites",
            };
            $.post( server_url, param, display_cart, "json" );
        }
    });

    // afficher le panier au chargement de la page
    const param = {
        page        : "favorite_ajax",
    };
    $.post( server_url, param, display_cart, "json" );

});

/*
 * Mise à jour du panier à l'écran
 */
function display_cart(cart_data)
{
    console.log(cart_data);

    // $.cookie("favorite", 1, { expires : 10 });
    // console.log( $.cookie("favorite"));
    // console.log(Cookies.get("favorite"));
    // console.log(readCookie('favorite'));

    // on efface le panier courant
    // $("ul#panier_contenu").html("");

    // on recrée les balises <li>
    // boucle sur le panier avec string et méthode .html()
    // remarque : il faut que ul#panier_contenu soit défini; si non, aucun effet.
    let s = '';
    $.each( cart_data, function( i, v )
    {
        s += "<li>" + v + "</li>"
    });
    $("ul#panier_contenu").html(s);

    // activer / désactiver les boutons add/del correspondant
    // https://stackoverflow.com/questions/6116474/how-to-find-if-an-array-contains-a-specific-string-in-javascript-jquery

    // on met tous les boutons "retirer favoris" à display:none
    $('button.del_favorite').css('display','none');
    // on met tous les boutons "ajouter favoris" à display:block
    $('button.add_favorite').css('display','block');

    // on inverse pour les articles du panier
    $.each( cart_data, function( k, id )
    {
        // produit in panier => cacher "add', montrer "del"
        $('button.add_favorite[for="'+id+'"]').css('display','none');
        $('button.del_favorite[for="'+id+'"]').css('display','block');
    });

    // $.each( $('article'), function( i, el ) {
    //     const id = $(this).attr('id');
    //     const foundPresent = cart_data.includes( id );
    //     console.log(foundPresent);
    //     if(foundPresent)
    //     {
    //         // produit in panier => add KO, del OK
    //         $('button.add[for="'+id+'"]').attr('disabled','disabled');
    //         $('button.del[for="'+id+'"]').removeAttr('disabled');
    //     }
    //     else
    //     {
    //         // produit out panier => add OK, del KO
    //         $('button.del[for="'+id+'"]').attr('disabled','disabled');
    //         $('button.add[for="'+id+'"]').removeAttr('disabled');
    //     }
    // });

    /*
    // autre solution :
    // écrire une boucle sur tous les boutons "ajouter"
    $.each( $("button.add"), function() {
        var prod = $(this).attr('for') ;
        // alert(prod);
        var foundPresent = cart_data.includes(prod); // true/false
        if(foundPresent)
        {
            $(this).attr( 'disabled', 'disabled' );
        }
        else
        {
            $(this).removeAttr( 'disabled');
        }
    });

    // mais alors il faut aussi écrire une boucle
    // sur tous les boutons "retirer"
    // => solution plus longue et moins maintenable
    $.each( $("button.delete_product"), function( i, v ) {
        ...
    });
    */
}

