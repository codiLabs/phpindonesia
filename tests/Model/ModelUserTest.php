<?php

/*
 * This file is part of the PHP Indonesia package.
 *
 * (c) PHP Indonesia 2013
 */

use app\Model\ModelBase;
use app\Model\ModelUser;

class ModelUserTest extends PHPUnit_Framework_TestCase {

	/**
	 * Set Up hook
	 */
	public function setUp() {
		// Setting Propel
		Propel::init(str_replace('app', 'conf', APPLICATION_PATH) . DIRECTORY_SEPARATOR . 'connection.php');
	}

	/**
	 * Tear Down hook
	 */
	public function tearDown() {
		$this->deleteDummyUser();
	}

	/**
	 * Cek konsistensi model User instance
	 */
	public function testCekKonsistensiModelUser() {
		$user = ModelBase::factory('User');

		$this->assertInstanceOf('\app\Model\ModelBase', $user);
		$this->assertInstanceOf('\app\Model\ModelUser', $user);
	}

	/**
	 * Cek fetching data
	 */
	public function testCekGetAllUser() {
		$this->createDummyUser();

		$user = new ModelUser();

		$allUsers = $user->getAllUser();

		$this->assertTrue(count($allUsers) > 0);
	}

	/**
	 * Cek update user
	 */
	public function testCekUpdateUserModelUser() {
		$auth = new ModelUser();

		$this->assertFalse($auth->updateUser(NULL, array()));
		$this->assertFalse($auth->updateUser(010101010, array()));

		// Valid update
		$this->createDummyUser();
		$dummyUser = ModelBase::ormFactory('PhpidUsersQuery')->findOneByName('dummy');

		$this->assertInstanceOf('\app\Parameter',$auth->updateUser($dummyUser->getUid(), array('name' => 'Not Dummy Anymore')));
	}

	/**
	 * Cek update user custom data
	 */
	public function testCekUpdateUserCustomModelUser() {
		$auth = new ModelUser();

		$this->assertFalse($auth->updateUserData(NULL, array()));
		$this->assertFalse($auth->updateUserData(010101010, array()));

		// Valid update
		$this->createDummyUser();
		$dummyUser = ModelBase::ormFactory('PhpidUsersQuery')->findOneByName('dummy');

		$this->assertInstanceOf('\app\Parameter',$auth->updateUserData($dummyUser->getUid(), array('realname' => 'Dummy User')));
	}


	/**
	 * Create dummy user
	 */
	protected function createDummyUser() {
		$user = new ModelUser();
		$user->createUser('dummy', 'dummy@oot.com', 'secret');
	}

	/**
	 * Delete dummy user
	 */
	protected function deleteDummyUser() {
		if (($dummyUser = ModelBase::ormFactory('PhpidUsersQuery')->findOneByName('dummy')) && ! empty($dummyUser)) {
			$dummyUser->delete();
		} elseif (($dummyUser = ModelBase::ormFactory('PhpidUsersQuery')->findOneByName('Not Dummy Anymore')) && ! empty($dummyUser)) {
			$dummyUser->delete();
		}
	}
}