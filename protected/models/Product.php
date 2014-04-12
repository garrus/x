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
 *
 * The followings are the available model relations:
 * @property User[] $users
 *
 * @method Product published
 * @method Product deleted
 */
class Product extends CActiveRecord
{

    /**
     * @var CUploadedFile
     */
    public $file=null;

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
            array('file', 'file', 'types' => 'html'),
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
			'users' => array(self::MANY_MANY, 'User', 'product_visit(product_id, customer_id)'),
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

    public function afterSave(){
        if ($this->file) {
            $this->file->saveAs($this->getHtmlPath());
        }
    }

    public function getHtmlPath(){
        return Yii::getPathOfAlias('application.data'). '/prod_html/'. $this->id. '.html';
    }

    public function getContent(){

        $htmlPath = $this->getHtmlPath();
        if (is_file($htmlPath)) {
            $content = file_get_contents($htmlPath);
            return str_replace(array('{name}', '{description}'), array($this->name, $this->description), $content);
        } else {
            return <<<HTML
<h1>{$this->name}</h1>
<p>{$this->description}</p>
HTML;
        }


    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
            'is_deleted' => 'Is Deleted',
            'file' => 'HTML File',
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
}
