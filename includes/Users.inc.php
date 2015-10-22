<?php

class User {
	protected $id;
	protected $first_name;
	protected $last_name;
	protected $email_address;
	protected $phone_number;
	protected $cell_phone_carrier_id;

	protected $type_id;
	protected $last_password_change;

	/**
	 * @param $username - email address to login with
	 * @param $password - plaintext password
	 *
	 * @return User
	 *
	 */
	public static function logIn( $email, $password ) {
		$data = array(
			':email'    => $email,
			':password' => $password
		);

		return self::loadAll( 'tUser.EmailAddress = :email AND tLogin.Passwd = :password', $data, false );
	}

	/**
	 * @param $users_id
	 *
	 * @return User
	 */
	public static function loadById( $users_id ) {
		$data = array( ':users_id' => $users_id );

		return self::loadAll( 'tUser.UserID = :users_id', $data, false );
	}

	/**
	 * @param string $where - WHERE of the sql query
	 * @param array $data - sql values to bind to the prepared query
	 *
	 * @return array
	 */
	public static function loadAll( $where = '', $data = array(), $return_array = true ) {
		global $con;

		if ( ! empty( $where ) ) {
			$where = ' WHERE ' . $where;
		}

		$sql =
			'SELECT
                tUser.UserID,
                FirstName,
                LastName,
                EmailAddress,
                PhoneNumber,
                CellPhoneCarrierID,

                tLogin.TypeID,
                tLogin.LastPasswordChange
            FROM tUser
            LEFT JOIN tLogin ON tLogin.UserID = tUser.UserID
            ' . $where . '';

		$statement = $con->prepare( $sql );
		$statement->execute( $data );

		$rows = $statement->fetchAll();

		$users = array();
		if ( ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$user = new User(
					array(
						'id'                    => $row['UserID'],
						'first_name'            => $row['FirstName'],
						'last_name'             => $row['LastName'],
						'email_address'         => $row['EmailAddress'],
						'phone_number'          => $row['PhoneNumber'],
						'cell_phone_carrier_id' => $row['CellPhoneCarrierID'],
						'type_id'               => $row['TypeID'],
						'last_password_change'  => $row['LastPasswordChange']
					)
				);

				if ( ! $return_array ) {
					return $user;
				}

				$users[] = $user;
			}
		}

		return $users;
	}

	public function __construct( $properties = array() ) {
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property => $value ) {
				$this->{$property} = $value;
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getFirstName() {
		return $this->first_name;
	}

	/**
	 * @param mixed $first_name
	 */
	public function setFirstName( $first_name ) {
		$this->first_name = $first_name;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->last_name;
	}

	/**
	 * @param mixed $last_name
	 */
	public function setLastName( $last_name ) {
		$this->last_name = $last_name;
	}

	/**
	 * @return mixed
	 */
	public function getEmailAddress() {
		return $this->email_address;
	}

	/**
	 * @param mixed $email_address
	 */
	public function setEmailAddress( $email_address ) {
		$this->email_address = $email_address;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber() {
		return $this->phone_number;
	}

	/**
	 * @param mixed $phone_number
	 */
	public function setPhoneNumber( $phone_number ) {
		$this->phone_number = $phone_number;
	}

	/**
	 * @return mixed
	 */
	public function getCellPhoneCarrierId() {
		return $this->cell_phone_carrier_id;
	}

	/**
	 * @param mixed $cell_phone_carrier_id
	 */
	public function setCellPhoneCarrierId( $cell_phone_carrier_id ) {
		$this->cell_phone_carrier_id = $cell_phone_carrier_id;
	}

	/**
	 * @return mixed
	 */
	public function getTypeId() {
		return $this->type_id;
	}

	/**
	 * @param mixed $type_id
	 */
	public function setTypeId( $type_id ) {
		$this->type_id = $type_id;
	}

	/**
	 * @return mixed
	 */
	public function getLastPasswordChange() {
		return $this->last_password_change;
	}

	/**
	 * @param mixed $last_password_change
	 */
	public function setLastPasswordChange( $last_password_change ) {
		$this->last_password_change = $last_password_change;
	}

}