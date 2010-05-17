<?php

/*

	This is Congif's error class

*/

class error {

	// constructor function
	function __construct($params){
		global $C;
		/*

			example :
				$db = new error(...);

		*/
		
		// if there is globally set error object
		if( $C[errorObject] && (!is_array($params) || !isset($params[createNew])) ){
			// calling global error
			return $C[errorObject]->show($params);
		}else{

			$this->templates[0] = array(
				'content' => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title>__label__</title>
	<style type="text/css" media="screen">
		__style__
	</style>
	</head>
	<body><div class="error">
	<h2 class="title">__code__ __label__ __title__</h2>
	<div class="message">__message__</div>
	__details__
	</div></body>
	</html>',
				'style' => '
				body {
					margin: 0;
					padding: 100px;
					font: 18px/25px "Lucida Grande", Lucida, Verdana, sans-serif;
					text-align: center;
				}

				a {
					color: black;
					outline: none;
				}

				.error {
					width: 600px;
					margin-left: auto;
					margin-right: auto;
					text-align: left;
					border: 3px solid red;
					background-color: #ffacac;
					padding: 20px;
					-moz-border-radius: 8px;
					-webkit-border-radius: 8px;
				}

				.error .title {
					padding: 0;
					margin: 0;
				}

				.error .message,
				.error pre {
					margin-top: 15px;
					padding-top: 15px;
					border-top: 1px dotted gray;
				}

				.error pre {
					font: 0.6em Monaco, "Courier New", Courier, mono;
				}',
				'label'         => 'Error',
				'beforeCode'    => '#',
				'beforeTitle'   => ' - ',
				'beforeDetails' => '<pre class="details">',
				'afterDetails'  => '</pre>'
			);

			return $this->show($params);
		}
	}


	// set params
	function set($params){
		// setting object's configuration

		// setting templates
			// default template
			if($params[template]){
				$this->templates[0] = array_merge($this->templates[0], $params[template]);
			}else if($params[html]){
				$this->templates[0][content] = $params[html];
			}
			// multiple templates
			if($params[tepmlates]){
				foreach ($params[tepmlates] as $code => $val){
					$this->templates[ $code ] = $val;
				}
			}

	}


	// error display function
	function show($params){
		/*

			parameters :     == explanination ==                == example ==
				code            error code                      // 402
				title           error title                     // Database Connection
				message         message to show                 // Database connection not established
				details         if there is technical details   // $db->error
				template/html   error's html template           // array( 'content' => '...html...' )
				                                                   // '-> posible array keys : content, beforeTitle, afterTitle, beforeMessage, afterMessage,
				                                                   //                          beforeDetails, afterDetails, beforeCode, afterCode
				templates       errors html templates           // multiple template arrays (indexed by error codes)
				setupOnly       dont show an error and dont die, use this for setting up error's defaults
				createNew       dont uses global error object


			example :
				- quick usage
					new error("Mysql Connection Problem!");

				- advanced usage
					new error(array(
							'title'  => 'Mysql Connection Problem',
							'message' => 'Mysql connection interrrupted',
							'details' => $db->message(),
							''
						))

		*/

		// setting params
		if( is_array($params) ){
			$this->code    = $params[code];
			$this->title   = $params[title];
			$this->message = $params[message];
			$this->details = $params[details];
			$this->custom  = $params;
			// setting other parameters
			$this->set( $params );
			// setup only?
			$showError = true;
			if( $params[setupOnly] )  $showError = false;
		}else{
			unset($this->title, $this->details);
			$this->message = $params;
			$this->code    = 0; // default
			$showError = true;
		}

		// build html, print and stop!
		if( $showError ){
			// if ajax request, die with message only
			if($_SERVER[HTTP_X_REQUESTED_WITH]){
				die($this->templates[0][label] .' : '. $this->message);
				// this will like
				// Error : MySQL Connetion not established!
			}else{
				die( $this->build_html() );
			}
		}

	}


	// error html builder
	function build_html(){

		// template code
		$template = $this->templates[ $this->code ];
		if( empty($template) ){
			// using default's template
			$template = $this->templates[0];
		}

		// main html code
		$html = $template[content];
		
		// inserting styles
		$html = str_replace('__style__', $template[style], $html);

		// injecting variables to template
			$html = str_replace('__label__', $template[label], $html);
			// code
			if( empty($this->code) ){
				$code = null;
			}else{
				$code = $template[beforeCode] . $this->code . $template[afterCode];
			}
			$html = str_replace('__code__', $code, $html);
			// title
			if( empty($this->title) ){
				$title = null;
			}else{
				$title = $template[beforeTitle] . $this->title . $template[afterTitle];
			}
			$html = str_replace('__title__', $title, $html);
			// message
			if( empty($this->message) ){
				$message = null;
			}else{
				$message = $template[beforeMessage] . $this->message . $template[afterMessage];
			}
			$html = str_replace('__message__', $message, $html);
			// detail
			if( empty($this->details) ){
				$details = null;
			}else{
				$details = $template[beforeDetails] . $this->details . $template[afterDetails];
			}
			$html = str_replace('__details__', $details, $html);
			// custom fields
			if( is_array($template[customFields]) ){
				foreach ($template[customFields] as $field){
					$html = str_replace('__'. $field .'__', $this->custom[ $field ], $html);
				}
			}

		// now we can return injected html result
		return $html;
	}


}

// redirector
class redirect{

	function __construct($message, $url = '/', $auto = false, $buttonLabel = 'Continue', $params = false){
		// if array
		if( is_array($message) ){
			if( $message[buttonLabel] ) $buttonLabel = $message[buttonLabel];
			if( $message[auto] )        $auto = $message[auto];
			if( $message[url] )         $url = $message[url];
			$message = $message[message];
		}

		// new instance
		$params[createNew] = true;

		// template
		$params[template][content] = '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
		"http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<title>Message</title>
		<style type="text/css" media="screen">
		__style__
		</style>
		</head>
		<body><div class="message">
		<h3>__message__</h3>
		__details__
		<input type="button" value="__buttonLabel__" onClick="window.top.location = \'__url__\';">
		__autoRedirect__
		</div></body>
		</html>';

		$params[template][style] = '
			body {
				margin: 0;
				padding: 100px;
				font: 18px/25px "Lucida Grande", Lucida, Verdana, sans-serif;
				text-align: center;
			}

			.message {
				width: 500px;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
				border: 3px solid gray;
				background-color: #efefef;
				padding: 30px;
				-moz-border-radius: 8px;
				-webkit-border-radius: 8px;
			}

			.message h3 {
				margin-top: 5px;
			}

			.message .details {
				margin-top: 15px;
				padding-top: 15px;
				border-top: 1px dotted gray;
			}

			.message pre {
				font: 0.6em Monaco, "Courier New", Courier, mono;
			}
		';

		// setting variables
		$params[message] = $message;

		$params[template][customFields] = array('url', 'buttonLabel', 'autoRedirect');
		$params[url]                    = $url;
		$params[buttonLabel]            = $buttonLabel;

		// if autoredirecting
		if( $auto ){
			$params[autoRedirect] = '
			<script type="text/javascript" charset="utf-8">
				setTimeout("window.top.location = \''. $url .'\';", '. $auto .');
			</script>
			';
		}

		// generating error
		return new error($params);

	}

}


?>