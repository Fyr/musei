<?php
App::uses('AppModel', 'Model');
class User extends AppModel {
	
	public $validate = array(
		'username' => array(
			'checkNotEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Field is mandatory',
			),
			'checkNameLen' => array(
				'rule' => array('between', 5, 15),
				'message' => 'The name must be between 5 and 15 characters'
			),
			'checkIsUnique' => array(
				'rule' => 'isUnique',
				'message' => 'That name has already been taken'
			)
		),
		'email' => array(
			'checkEmail' => array(
				'rule' => 'email',
				'message' => 'Email is incorrect'
			),
			'checkIsUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email has already been used'
			)
		),
		'password' => array(
			'checkNotEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Field is mandatory'
			),
			'checkPswLen' => array(
				'rule' => array('between', 5, 15),
				'message' => 'The password must be between 5 and 15 characters'
			),
			'checkMatchPassword' => array(
				'rule' => array('matchPassword'),
				'message' => 'Your password and its confirmation do not match',
			)
		),
		'password_confirm' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Field is mandatory',
			)
		)
	);

	public function matchPassword($data){
		if($data['password'] == $this->data['User']['password_confirm']){
			return true;
		}
		$this->invalidate('password_confirm', 'Your password and its confirmation do not match');
		return false;
	}
	
	public function beforeValidate($options = array()) {
		if (Hash::get($options, 'validate')) {
			if (!Hash::get($this->data, 'User.password')) {
				$this->validator()->remove('password');
				$this->validator()->remove('password_confirm');
			}
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}

}
