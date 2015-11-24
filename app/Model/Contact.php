<?
App::uses('AppModel', 'Model');
class Contact extends AppModel {
	public $useTable = false;
	
	public $validate = array(
		'username' => array(
			'checkNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Field cannot be blank',
			),
			'checkNameLen' => array(
				'rule' => array('between', 5, 15),
				'message' => 'The name must be between 5 and 15 characters.'
			),
		),
		'email' => array(
			'checkEmail' => array(
				'rule' => 'email',
				'message' => 'Email is incorrect'
			)
		)
	);

}
