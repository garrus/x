<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property int $is_deleted
 * @property string $update_time
 * @property string $create_time
 * @property string $content
 * @property string $cate
 *
 * The followings are the available model relations:
 *
 * @method Product published
 * @method Product deleted
 */
class Product extends CActiveRecord
{

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>128),
			array('description', 'length', 'max'=>1024),
            array('cate', 'length', 'max' => 64),
            array('content,is_deleted', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description', 'safe', 'on'=>'search'),
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
		);
	}

    public function scopes(){
        return array(
            'published' => array(
                'condition' => 'is_deleted=0',
            ),
            'deleted' => array(
                'condition' => 'is_deleted=1',
            )
        );
    }

    public function getDescriptionInShort(){

        return $this->description;
    }

    protected function beforeSave(){
        $this->update_time = new CDbExpression('CURRENT_TIMESTAMP');
        return parent::beforeSave();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '名称',
			'description' => '简介',
            'cate' => '分类',
            'is_deleted' => '隐藏',
            'content' => '详情',
            'create_time' => '创建时间',
            'update_time' => '最近修改',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function setIsDeleted($flag){
        $flag = $flag ? 1 : 0;
        if ($this->is_deleted != $flag) {
            $this->is_deleted = 1;
            $this->saveAttributes(array('is_deleted'));
        }
    }

    public function refreshUpdateTime(){
        $this->update_time = new CDbExpression('CURRENT_TIMESTAMP');
        $this->saveAttributes(array('update_time'));
    }

    public static function getList($includeDeleted=false){

        $items = array();
        $db = self::model()->getDbConnection();

        $sql = $db->createCommand()
            ->select('id,name,cate')
            ->from(self::model()->tableName())
            ->order('cate,name');
        if (!$includeDeleted) {
            $sql->where('is_deleted=0');
        }

        $list = $sql->queryAll(true);

        foreach ($list as $row) {
            $items[$row['cate']][] = array('id' => $row['id'], 'name' => $row['name']);
        }
        return $items;

    }
}
