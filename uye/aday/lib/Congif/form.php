<?php

/*

	Congif's html form builder class


	Input Types :
		text
			name
			email

		textarea

		integer
		decimal

		datetime - timestamp
		date
		time

		select
		radio
		check


	Core filed array
		array(
			'type'     => 'textarea'
			'name'     => 'field_name',
			'default'  => 'defaultValue',
			'attr'     => 'class="input-field"',
			'min'      => 4,
			'max'      => 20       // or 'limit' => '4, 20'
		)


	Complete field array
		array(
			'liAttr'      => 'class="list"',
			'label'       => 'Name',
			'labelAttr'   => 'class="mylabel"',
			'required'    => true,
			'desc'        => 'Description about this field',
			'descAttr'    => 'class="description"',
			'error'       => 'There was an error!',
			'errorAttr'   => 'class="myerror"',
			-- AND CORE FIELD ARRAY KEYS --
		);

*/


class form{

	// constructer function
	function __construct($params = false){
		// one prameter
		if( !is_array($params) ){
			$action = $params;
			unset($params);
			$params[action] = $action;
		}
		// calling create function
		$this->create($params);
	}


	// form builder main function
	function create($params){
		// default parameters
		$this->name          = 'myform';      // form name
		$this->attr          = '';            // form attribute
		$this->action        = 'action.php';  // post to...
		$this->method        = 'post';        // method
		$this->multipart     = false;         // encypte attribute
		$this->labelAligment = 'left';
		// setting given params
		foreach ($params as $key => $val){
			if( $params[ $key ] ){
				$this->$key = $val;
			}
		}
		// fields
		if( $params[fields] ) $this->addFields($params[fields]);
		// if renderNow
		if( $params[renderNow] ) $this->render();
	}


	// render function
	function render($dontPrint = false){
		// if there is no fields
		if( !$this->fields ) new error('There is no input fields in this form');

		// empty
		$html = '';

		// fields
		$i = 0;
		foreach ($this->fields as $field){
			$i++;
			if( $field[type] == 'hidden' ){
				$hidden .= "\n".'<input type="hidden" name="'. $field[name] .'" value="'. $field['default'] .'" '. $field[attr] .'>';
			}else{
				$html .= "\n\t".'<li '. $field[liAttr] .'>';
				// printing label
				if( $field[label] ) $html .= '<label for="field_'. $i .'" class="title '. $field[labelClass] .'" '. $field[labelAttr] .'>'. $field[label] . ( $field[required] ? ' <span class="req">*</span>':'' ) .'</label>'."\n\t";

					// printing html by field type
					switch ($field[type]) {

						case "html": {
							$html .= $field[html];
							break;
						}

						case "text":
						case "password": {
							$html .= '<input type="'. $field[type] .'" name="'. $field[name] .'" value="'. $field['default'] .'" id="field_'. $i .'" '. $field[attr] .'>';
							break;
						}

						case "textarea": {
							$html .= '<textarea name="'. $field[name] .'" id="field_'. $i .'" '. $field[attr] .'>'. $field['default'] .'</textarea>';
							break;
						}

						case "select": {
							$html .= '<select name="'. $field[name] .'" id="field_'. $i .'" '. $field[attr] .' '. $field[attr] .'>';
							if( $field[values] ){
								foreach ($field[values] as $key => $display){
									$value = (isset($key) ? $key : $display);
									$html .= '<option value="'.$value.'"'.($field['default'] == $value ? ' selected="true"':'' ).'>'. $display .'</option>'."\n";
								}
							}
							$html .= '</select>';
							break;
						}

						case "radio":
						case "check": {
							if( $field[values] ){
								$j = 1;
								foreach ($field[values] as $key => $display){
									$name = $field[name];
									if( $field[type] == 'check' ) $name .= '['. $key .']';
									$html .= '<span class="option">';
									$value = (isset($key) ? $key : $display);
									$html .= '<input type="'. ($field[type] == 'radio' ? 'radio" value="'.$value :'checkbox') .'" name="'. $name .'" '.($field['default'] == $value ? ' checked="true"':'' ).' id="input_'.$i.'_'.$j.'">';
									$html .= '<label for="input_'.$i.'_'.$j.'">'.$display .'</label>';
									$html .= '</span>';
									if( $field[optionLine] ) $html .= '<br />';
									$html .= "\n\t";
									$j++;
								}
							}
							break;
						}

						case "button":
						case "submit":
						case "reset": {
							$html .= '<input type="'. $field[type] .'" name="'. $field[name] .'" value="'. $field['default'] .'" id="field_'. $i .'" '. $field[attr] .'>';
							break;
						}

					}

				// description
				if( $field[desc] )  $html .= '<div class="desc '. $field[descClass] .'" '. $field[descAttr] .'>'. $field[desc] .'</div>';
				// error
				if( $field[error] ) $html .= '<div class="error '. $field[errorClass] .'" '. $field[errorAttr] .'>'. $field[error] .'</div>';
				// ending li
				$html .= '</li>'."\n";
			}
		}


		// form html
		$output = "\n".'<form class="Form '. $this->labelAligment .' '. $this->class .'" action="'. $this->action .'" method="'. $this->method .'"'. ( $this->multipart ? ' enctype="multipart/form-data"':'' ) .' '. $this->attr .'>'.
		$hidden.
		"\n".'<ul>'.$html.'</ul>'.
		'</form>'."\n\n";

		// output
		if($dontPrint) return $output;
		else print $output;
	}
	// aliases
	function build(){
		$this->render();
	}


	// addfield
	function addField($params){
		if( !in_array($params[type], explode(' ', 'html button submit reset select')) && !$params[name] ) return false;
		// defaults
		if( !$params[type] ) $params[type] = 'text';
		if( !$params[label] ) $params[label] = '';
		// adding to fields array
		$this->fields[] = $params;
		return true;
	}

	// addfields
	function addFields($params){
		foreach ($params as $field){
			$this->addField($field);
		}
	}


	// html note
	function html($html, $params = false){
		$params[type] = 'html';
		$params[html] = $html;
		$this->addField($params);
	}


	// text input field function
	function hidden($name = 'input[]', $value, $params = false){
		$params[type]      = 'hidden';
		$params[name]      = $name;
		$params['default'] = $value;
		// adding field to object
		$this->addField($params);
	}


	// text input field function
	function text($label, $name = 'input[]', $params = false){
		$params[label] = $label;
		$params[name]  = $name;
		// adding field to object
		$this->addField($params);
	}

	// password field function
	function password($label, $name = 'input[]', $params = false){
		$params[type] = 'password';
		$this->text($label, $name, $params);
	}

	// integer field function
	function int($label, $name = 'input[]', $params = false){
		$this->text($label, $name, $params);
	}


	// textarea field function
	function textarea($label, $name = 'input[]', $params = false){
		$params[type]  = 'textarea';
		$params[label] = $label;
		$params[name]  = $name;
		// adding field to object
		$this->addField($params);
	}


	// radiobutton field function
	function radio($label, $values, $name = 'input[]', $params = false){
		$params[type]   = 'radio';
		$params[label]  = $label;
		$params[values] = $values;
		$params[name]   = $name;
		// adding field to object
		$this->addField($params);
	}

	// checkbox field function
	function check($label, $values, $name = 'input[]', $params = false){
		$params[type]   = 'check';
		$params[label]  = $label;
		$params[values] = $values;
		$params[name]   = $name;
		// adding field to object
		$this->addField($params);
	}

	// selectbox field function
	function select($label, $values, $name = 'input[]', $params = false){
		$params[type]   = 'select';
		$params[label]  = $label;
		$params[values] = $values;
		$params[name]   = $name;
		// adding field to object
		$this->addField($params);
	}


	// buttons
	function button($label, $name = '', $params = false){
		if(!$params[type]) $params[type] = 'button';
		$params['default'] = $label;
		$params[name]      = $name;
		// adding field to object
		$this->addField($params);
	}
	// submit button
	function submit($label, $name = 'action', $params = false){
		$params[type] = 'submit';
		$this->button($label, $name, $params);
	}

}

?>
