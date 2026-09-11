/**
 * mise à jour du compteur, grâce à une requête FETCH
 * incrémentation ou récupération valeur courante du compteur sur le serveur
 * @param action "get" (default) or "increment"
 */
function getset_counter(action)
{
    // set param
    let param;
    // console.log("got it, 10 ");

    // on crée le param pour la requête FETCH, mode "increment" ou "get"
    // attributs "return" et "page" exigés par AWebWiz
    param = {
        returnType  : "application/json",
        page        : "Counter_fetch",
        action      : "increment",
    };

    // Envoyer la requête avec Fetch
    fetch(window.location.pathname, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Format attendu par PHP pour $_POST
        },
        body: new URLSearchParams(param).toString(), // Convertit l'objet en format "clé=valeur"
    })

    .then(response => {
        // get response and validate response format
        if (!response.ok)
        {
            throw new Error(`Erreur HTTP : ${response.status}`);
        }
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json'))
        {
            throw new Error("La réponse n'est pas au format JSON, mais : " + contentType);
        }
        return response.json(); // Récupère la réponse
    })

    .then(json_data => {
        // on gère le retour : mise à jour du compteur
        // on valide le retour de la fonction
        // console.log(`mise à jour du compteur : ${json_data.data.cpt_val}`)
        if( ! json_data.success )
        {
            throw new Error(`Erreur requête  : ${json_data.error}`);
        }

        // mise à jour
        document.getElementById('compteur').textContent = json_data.data.cpt_val
    })

    .catch(error => {
        // Process error
        document.getElementById('fetch_error').textContent = `Erreur : ${error.message || 'Inconnue'}`;
        console.error('Problème avec js/fetch: ', error); // Affiche l'objet error complet
    });
}


// définition des évènements sur les boutons
document.addEventListener( 'DOMContentLoaded', (event) => {
    // associer les évènements aux boutons après le chargement de la page
    document.getElementById('b_compteur')
        .addEventListener('click', () => getset_counter("increment"));

    // mettre le compteur à jour
    getset_counter("get");
});

