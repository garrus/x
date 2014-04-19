<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-19
 * Time: 下午1:31
 */

class ConfigManager extends CApplicationComponent{

    /**
     * @var string
     */
    public $tableName = 'config';


    /**
     * @var CAttributeCollection
     */
    private $_config;

    /**
     * @var array  key => bool. the value specifies if the config item is synchronized with db rows.
     */
    private $_keys = null;

    public function init(){
        $this->_config = new CMap();
        Yii::app()->attachEventHandler('onEndRequest', array($this, 'flush'));
        parent::init();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name){

        if ($this->hasItem($name)) {
            return $this->getItem($name);
        } else {
            return parent::__get($name);
        }
    }

    /**
     * @param string $name
     * @param mixed $key
     * @return mixed|void
     */
    public function __set($name, $key) {
        if ($this->hasItem($name)) {
            $this->setItem($name, $key);
        } else {
            parent::__get($name, $key);
        }
    }


    /**
     * @param string|array $name
     * @return mixed if $name is an array, return an array that indexed by item name; otherwise return a scalar.
     */
    protected function loadItem($name) {

        $items = Yii::app()->db->createCommand()
            ->select('*')
            ->from($this->tableName)
            ->where(array('in', 'name', (array)$name))
            ->queryAll(true);

        if (!is_array($name)) {
            return $items[0]['value'];
        } else {
            $ret = array();
            foreach ($items as $row) {
                $ret[$row['name']] = $row['value'];
            }
            return $ret;
        }

    }


    /**
     * @param $name
     * @return bool
     */
    public function hasItem($name){
        if ($this->_keys === null) {
            $keys = Yii::app()->db->createCommand('select `name` from `'. $this->tableName. '`;')->queryColumn();
            $this->_keys = array_flip($keys);
            $this->_keys[$keys[0]] = 1;
        }

        return isset($this->_keys[$name]);
    }

    /**
     * @param $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getItem($name) {
        if ($this->_config->contains($name)) {
            return $this->_config->itemAt($name);
        } elseif ($this->hasItem($name)) {
            $value = $this->loadItem($name);
            $this->_config->add($name, $value);
            return $value;
        } else {
            throw new InvalidArgumentException('Unable to find config item "'. $name .'".');
        }
    }

    /**
     * @param $name
     * @param $value
     * @param bool $createNewItem
     */
    public function setItem($name, $value, $createNewItem=false) {
        if ($this->_config->contains($name)) {
            if ($this->_config->itemAt($name) !== $value) {
                $this->_config->add($name, $value);
                $this->_keys[$name] = false;
            }
        } elseif ($this->hasItem($name)) {
            $this->_config->add($name, $value);
            $this->_keys[$name] = false;
        } elseif ($createNewItem) {
            $this->createNewItem($name, $value);
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws InvalidArgumentException
     */
    public function createNewItem($name, $value) {
        if ($this->hasItem($name)) {
            throw new InvalidArgumentException('Can not create new config item, as there is already a config item named "'. $name. '".');
        }
        $this->_config->add($name, $value);
        $this->_keys[$name] = false;
    }

    /**
     * Flush modified config item into db table.
     */
    public function flush(){
        if ($this->_keys) {
            $data = array();
            foreach ($this->_keys as $key => $synced) {
                if (!$synced) $data[$key] = $this->_config->itemAt($key);
            }
            if (count($data)) {
                $sql = Yii::app()->db->createCommand('update `'. $this->tableName. '` set `value`=:value where `name`=:name limit 1');
                $sql->prepare();
                foreach ($data as $name => $value) {
                    $this->_keys[$name] = $sql->execute(array(':name' => $name, ':value' => $value));
                }
            }
        }
    }


    public function getAll(){

        $this->hasItem('s');

        return $this->loadItem(array_keys($this->_keys));

    }


} 