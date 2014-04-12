<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $login_name
 * @property string $password
 * @property string $salt
 * @property string $first_name
 * @property string $last_name
 * @property string $display_name
 * @property string $role
 * @property string $status
 * @property string $last_login_time
 * @property string $email
 * @property string $address
 * @property string $phone
 * @property string $mobile
 * @property string $qq
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property CustomerRelation[] $customerRecords
 * @property CustomerRelation $repRecord
 * @property Product[] $visitedProducts
 * @property User[]  $customers
 * @property User $rep
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login_name, first_name, last_name', 'required'),
			array('login_name,  display_name, phone, mobile, qq', 'length', 'max'=>16),
			array('first_name, last_name, role', 'length', 'max'=>8),
			array('status', 'length', 'max'=>7),
			array('email, password, address', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login_name, password, salt, first_name, last_name, display_name, role, status, last_login_time, email, address, phone, mobile, qq, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customerRecords' => array(self::HAS_MANY, 'CustomerRelation', 'rep_id'),
			'repRecord' => array(self::HAS_ONE, 'CustomerRelation', 'customer_id'),

            'customers' => array(self::HAS_MANY, 'User', array('rep_id', 'customer_id'), 'through' => 'customerRecords'),
            'rep' => array(self::HAS_ONE, 'User', array('customer_id', 'rep_id'), 'through' => 'repRecord'),

			'visitedProducts' => array(self::MANY_MANY, 'Product', 'product_visit(customer_id, product_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login_name' => Yii::t('user', 'Login Name'),
			'password' => Yii::t('user', 'Password'),
			'salt' => Yii::t('user', 'Salt'),
			'first_name' => Yii::t('user', 'First Name'),
			'last_name' => Yii::t('user', 'Last Name'),
			'display_name' => Yii::t('user', 'Display Name'),
			'role' => Yii::t('user', 'Role'),
			'status' => Yii::t('user', 'Status'),
			'last_login_time' => Yii::t('user', 'Last Login Time'),
			'email' => Yii::t('user', 'Email'),
			'address' => Yii::t('user', 'Address'),
			'phone' => Yii::t('user', 'Phone'),
			'mobile' => Yii::t('user', 'Mobile'),
			'qq' => Yii::t('user', 'QQ'),
			'create_time' => Yii::t('user', 'Create Time'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('login_name',$this->login_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @param $repId
     * @return $this
     */
    public function isCustomerOf($repId) {

        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'role="customer"',
            'with' => array(
                'repRecord' => array(
                    'joinType' => 'inner join',
                    'condition' => 'repRecord.rep_id=:rep_id',
                    'params' => array(
                        'rep_id' => $repId
                    )
                )
            )
        ));
        return $this;
    }


    public function getRoleList(){
        return array(
            'admin' => Yii::t('user', 'Administrator'),
            'rep' => Yii::t('user', 'Sales Rep'),
            'customer' => Yii::t('user', 'Customer'),
        );
    }


    protected function beforeSave(){

        if ($this->isNewRecord) {
            if (!$this->salt) {
                $this->salt = substr(md5(uniqid('user-signup', true)), 0, 24);
            }
            if (!$this->password) {
                $this->password = self::encryptPassword(uniqid(), $this->salt); // random password
            } else {
                $this->password = self::encryptPassword($this->password, $this->salt); // random password
            }
        }
        return parent::beforeSave();
    }

    public function getDisplayName(){
        if (!$this->display_name) {
            return $this->last_name. $this->first_name;
        }
        return $this->display_name;
    }

    /**
     * @param $password
     */
    public function updatePassword($password){

        $this->password = self::encryptPassword($password, $this->salt);
        $this->saveAttributes(array('password'));
    }

    /**
     * @param $password
     * @return string
     */
    public function validatePassword($password) {
        return $this->password == self::encryptPassword($password, $this->salt);
    }

    /**
     * @param string $password
     * @param string $salt
     * @return string
     */
    public static function encryptPassword($password, $salt){
        return md5(md5($password). $salt);
    }

    /**
     * @param $name
     * @return bool
     */
    public static function existsByName($name){

        return self::model()->exists('login_name=:login_name', array('login_name' => $name));
    }
}
