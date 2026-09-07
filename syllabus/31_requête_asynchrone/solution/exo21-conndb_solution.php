<?php

$message=array();

/*
 * Establishing Connection with Server
 */
function model_conn_open()
{
	global $message;
	static $db_connector;

	if(isset($db_connector) and !empty($db_connector))
	{
		return $db_connector;
	}
	else
	{
		try
		{
			$db_connector = mysqli_connect( "localhost", "root", "", "4ipdw_sample" );
			return $db_connector;
		}
		catch (Exception $e) 
		{
			// Closing Connection with Server
			mysqli_close($conn);
			$message[] = 'Caught exception: ' . $e->getMessage();
			return false;
		}
	}
}

/*
 * Closing connection with Server
 */
function model_conn_close()
{
	$conn = model_conn_open();
	mysqli_close($conn);	
}

/*
 * Insert New Deal
 */
function model_insert_deal($deal_name)
{
	global $message;

	try 
	{
		$conn = model_conn_open();

		// Query of SQL wrt deal
		$q = <<< SQL
			INSERT INTO t_deal (name_dea)
			VALUES ('$deal_name');
SQL;
		
		// execute the INSERT query 
		$result = mysqli_query($conn, $q );
		// count number of affected rows
		// must be 1 (one)
		$n = mysqli_affected_rows($conn);
		$message[] = "$n ligne(s) affectée(s)";
		$message[] = "query : $q";

		// confirm insertion 
		$b = mysqli_commit($conn);
		if( ! $b ) throw new Exception("commit failed");

		// Closing Connection with Server
		// mysqli_close($db_connector);

		return "New deal '$deal_name' inserted successfully...!!";
	}
	catch (Exception $e) 
	{
		// Closing Connection with Server
		mysqli_close($conn);
		$message[] = 'Caught exception: ' . $e->getMessage();
		return false;
	}
}

/*
 * param $ajax_mode boolean : false par défaut, true si en mode AJAX
 */
function view_all_deals($ajax_mode=false)
{
	global $message;

	try 
	{
		$conn = model_conn_open();

		$q = <<< SQL
		SELECT name_dea AS partie 
		FROM t_deal 
		WHERE is_active_dea IS TRUE ;
SQL;
		$result = mysqli_query($conn, $q );
		$select_html_code = "";

		while ($row = mysqli_fetch_array($result))
		{
			// concatenating HTML code into a single string
			$select_html_code .= <<< HTML
			<li>
				{$row['partie']}
			</li>
HTML;
		}

		// freeing memory for other use 
		mysqli_free_result($result);
		
		// si mode AJAX : return $select_html_code;
		
		// affichage du code HTML généré 
		if($ajax_mode)
		{
			return $select_html_code;
		}
		?>
		<div class="main">
			<h2>Parties en cours</h2>
			<p><em>SELECT * FROM t_deal</em></p>
			<ul id="list_all_deals">
				<?=$select_html_code?>
			</ul>
		</div>
		<?php
	}
	catch (Exception $e) 
	{
		// Closing Connection with Server
		model_conn_close();
		$message[] = 'Caught exception: ' . $e->getMessage();
		return false;
	}

}

function view_new_deal_form()
{
	?>					
	<div class="main">
		<!-- method can be set POST for hiding values in URL-->
		<h2>Insérer une nouvelle partie</h2>
		<p><em>INSERT INTO t_deal (name_dea) <br/>VALUES (...)</em></p>
		<label>Deal Name:</label><br />
		<textarea rows="5" cols="25" name="deal_name" id="deal_name"></textarea>
		<br />
		<button class="submit" id="submit" >
			Insert New Deal
		</button>
	</div>
	<?php
}

/*
 * param $ajax_mode boolean : false par défaut, true si en mode AJAX
 */
function view_message($ajax_mode=false)
{
	global $message;
	// if( empty($message) ) return '';

	$liste = '';
	foreach( $message as $m )
	{
		$liste .= "<li>$m</li>";
	}

	if($ajax_mode)
	{
		// on retourne juste le code "<li>...."
		return $liste;
	}

	?>
	<div class="main">
		<h2>Messages du système</h2>
		<ul id="alert">
			<?=$liste;?>
		</ul>
	</div>
	<?php
}


function view_footer()
{
	?>
</body>
</html>
	<?php
}

function view_header()
{
	?>
<!doctype html>
<html>
<head>
	<title>Exercice AJAX / MySQL</title>
	<style>
	@import url(http://fonts.googleapis.com/css?family=Droid+Serif); /* to import google font style */ 
	body
	{
		width:400px;
		border:1px dashed #aaa;
		padding:10px;
		margin:2% 5%;
		background-color:aliceblue;
	}
	.main
	{
		margin:5%;
		background: #fff;
		padding:5%;
		font-family: 'Droid Serif', serif;
		font-size:14px;
	}
	.main h2
	{
		text-align:center;
		text-shadow:2px 2px 2px #cfcfcf; 
	}
	h1
	{
		height:70px;
		text-align:center;
		text-shadow:2px 2px 2px #cfcfcf; 
	}
	textarea
	{ 
		width:100%; 
		height:60px; 
		border-radius:1px;
		box-shadow:0px 0px 1px 2px #123456; 
		margin-top:10px;
		padding:7px;
		border:none;
	}	
	.input
	{ 
		width:100%; 
		height:30px; 
		border-radius:2px;
		box-shadow:0px 0px 1px 2px #123456; 
		margin-top:10px;
		padding:7px;
		border:none;
		margin-bottom:20px;
	}
	.submit
	{
		color: white;
		border-radius:3px;
		background: #1F8DD6;
		padding:5px;
		margin-top:40px;
		border:none;
		width:100%; 
		height:30px;
		box-shadow:0px 0px 1px 2px #123456;
		font-size:18px;	   
	}

	p.alert, ul.alert li
	{
		color:red;
		text-align:left;
	}
	</style>
	<script
	 src="https://code.jquery.com/jquery-3.4.1.js"   
	 integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	 crossorigin="anonymous"></script>
	<script>
	$( function() {

		// récupérer un contenu via $.post
		// puis traiter ce contenu
		$('button#submit').click(function() {
			// on récupère la valeur introduite dans le textarea
			// pour construire le param de la requête AJAX
			var param = {
				submit : '',
				deal_name : $('textarea#deal_name').val()
			};
			// Le retour de la requête, en format JSON,
			// contiendra uniquement 
			// les données nécessaires et suffisantes pour 
			// rafraîchir la page, à savoir : 
			// - la liste des deals, mise à jour 
			// - les messages du serveur.
			// Pour simplifier le travail de programmation,
			// ces valeurs seront en format HTML. 
			$.post('', param, function(data) {
				console.log('data reçues:');
				console.log(data.all_deal);
				// insérer la liste des deals, mise à jour
				$("ul#list_all_deals").html(data.all_deal);
				console.log(data.message);
				// insérer les messages du serveur
				$("ul#alert").html(data.message);
			}, "json" );
		});
	});
	</script>
</head>
<body>

<h1>Handling Database Using PHP, jQuery and AJAX.</h1>
	<?php
}

///////////////////////////////////////////////////////////////////////

// CONTROLLER ici
model_conn_open();

// Example with INSERT 
// insert new deal, the name of this new deal coming from the form
if(isset($_POST['submit']))
{
	// Requête AJAX !!!
	
	// Fetching variables of the form 
	$deal = $_POST['deal_name'];
	if( ! empty($deal))
	{
		$message[] = model_insert_deal($deal);
	}
	else
	{
		$message[] = "Insertion Failed <br/> Some Fields are left empty !";   
	}
	
	// On construit ici la structure de données 
	// à retourner au client
	$ret = array(
		'all_deal' => view_all_deals(true),
		'message' => view_message(true),
	);
	
	// on s'arrête ici sinon on regénérère toute la page
	echo json_encode($ret);
	exit;
}


// Entête de page HTML
view_header();

// Example with SELECT 
// Afficher l'ensemble des parties 
view_all_deals();

// Afficher le form pour 
view_new_deal_form();

// Afficher les messages 
view_message($message);

// Fin de page HTML
view_footer();

model_conn_close();
?>